<?php

namespace App\Http\Controllers;

use App\Order;

class AprioriController extends Controller
{
    //
    public function apriori()
    {
        //generate data dari database
        $listProduct = [];
        $orders = Order::all();
        foreach ($orders as $o) {

            $list_item = [];
            foreach ($o->products as $p) {
                array_push($list_item, $p->product_name);
            }
            if (count($list_item) > 0) {
                array_push($listProduct, $list_item);
            }

        }
        //proses configurasi algoritma apriori
        $installer = new \CodedHeartInside\DataMining\Apriori\Installer();
        $installer->createRunningEnvironment();
        $aprioriConfiguration = new \CodedHeartInside\DataMining\Apriori\Configuration();

        //proses pemberian nilai minimum support dan minimum confidence
        $aprioriConfiguration->setDisplayDebugInformation();
        $aprioriConfiguration->setMinimumThreshold(2) // Default is 2
            ->setMinimumSupport(0.2) // Default is 0.1
            ->setMinimumConfidence(5);
        $dataSet = $listProduct;
        //masukan dataset ke dalam class algoritma apriori
        $dataInput = new \CodedHeartInside\DataMining\Apriori\Data\Input($aprioriConfiguration);
        $dataInput->flushDataSet()
            ->addDataSet($dataSet)
        ;
        //jalankan proses algoritma apriori
        $aprioriClass = new \CodedHeartInside\DataMining\Apriori\Apriori($aprioriConfiguration);
        $aprioriClass->run();
        $newRecords = [];
        foreach ($aprioriClass->getSupportRecords() as $record) {
            array_push($newRecords, $record);
        }
        echo json_encode($newRecords);

    }
}
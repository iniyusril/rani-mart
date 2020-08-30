<?php

namespace App\Http\Controllers;

use DB;

class AprioriController extends Controller
{
    //
    public function apriori()
    {
        $listProduct = [];
        $sql = <<<SQL
        SELECT
            DISTINCT od.order_id
        FROM  order_details od
        SQL;
        $datas = DB::select($sql);
        foreach ($datas as $data) {
            $sql = <<<SQL
            select p.product_name from order_details od
            inner join products p
            on p.id  = od.product_id
            where od.order_id  = ?
            SQL;
            $result = DB::select($sql, [$data->order_id]);
            $kolom = array_column($result, 'product_name');
            array_push($listProduct, $kolom);
        }

        $installer = new \CodedHeartInside\DataMining\Apriori\Installer();
        $installer->createRunningEnvironment();
        $aprioriConfiguration = new \CodedHeartInside\DataMining\Apriori\Configuration();

        // Configuring the boundries is optional
        $aprioriConfiguration->setDisplayDebugInformation();
        $aprioriConfiguration->setMinimumThreshold(2) // Default is 2
            ->setMinimumSupport(0.2) // Default is 0.1
            ->setMinimumConfidence(5);
        $dataSet = $listProduct;

        $dataInput = new \CodedHeartInside\DataMining\Apriori\Data\Input($aprioriConfiguration);
        $dataInput->flushDataSet()
            ->addDataSet($dataSet)
            ->addDataSet($dataSet) // In this case, the data set is added twice to create more testing data
        ;
        $aprioriClass = new \CodedHeartInside\DataMining\Apriori\Apriori($aprioriConfiguration);
        $aprioriClass->run();

        foreach ($aprioriClass->getSupportRecords() as $record) {
            print_r($record);
            echo "<br/>";

            // Outputs:
            // Array
            // (
            //     [itemIds] => Array
            //     (
            //         [0] => 1
            //         [1] => 4
            //         [2] => 6
            //         [3] => 7
            //     )
            //
            //     [support] => 0.060606060606061
            // )
        }
        echo "<br/>";
        foreach ($aprioriClass->getConfidenceRecords() as $record) {
            print_r(json_encode($record));
            // Outputs
            // Array
            // (
            //     [if] => Array
            //     (
            //       [0] => 1
            //       [1] => 7
            //     )
            //
            //     [then] => 3
            //     [confidence] => 1
            // )
        }
    }
}
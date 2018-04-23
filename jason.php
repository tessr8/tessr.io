public static function getTransactionsERC20($nodeCode, $tokenContractAddress, $address, $fromBlock, $toBlock) {
        $nodes = Config::getSettings('nodes');
        if (!array_key_exists($nodeCode, $nodes)) {
            throw new \Exception("Invalid node code '{$nodeCode}'");
        }

        $logs = self::_request($nodes[$nodeCode], [
            'method' => "eth_getLogs",
            'params' => [[
                'fromBlock' => $fromBlock,
                'toBlock' => $toBlock,
                'address' => $tokenContractAddress,
                'topics' => [
                    null, null,
                    "0x000000000000000000000000" . substr($address, 2)
                ]
            ]],
            'id' => 1,
            'jsonrpc' => "2.0"
        ]);

        if (!array_key_exists('result', $logs) || empty($logs['result'])) {
            return [];
        }

        $txnsData = array_filter($logs['result'], function($e) {
            return ($e['type'] == "mined");
        });

        $txns = [];
        foreach ($txnsData as $txData) {
            $tx = self::_request($nodes[$nodeCode], [
                'method' => "eth_getTransactionByHash",
                'params' => [
                    $txData['transactionHash']
                ],
                'id' => 1,
                'jsonrpc' => "2.0"
            ]);

            if (!array_key_exists('result', $tx)) {
                continue;
            }

            //var_dump($tx);
            $input = $tx['result']['input'];

            $method = substr($input, 0, 10);
            $toAddress = substr($input, 10, 64);
            $amount = substr($input, 74, 64);
            if ($method !== "0xa9059cbb") { // transfer
                continue;
            }

            $txn = $tx['result'];
            $txn['action']['from'] = $txn['from'];
            $txn['action']['to'] = "0x" . substr($toAddress, 24);
            $txn['action']['value'] = $amount;
            $txns[] = $txn;
        }

        return $txns;
    }
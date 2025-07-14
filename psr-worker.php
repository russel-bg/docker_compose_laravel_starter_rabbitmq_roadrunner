<?php



require __DIR__ . '/vendor/autoload.php';


$consumer = new Spiral\RoadRunner\Jobs\Consumer();
$shouldBeRestarted = false;

while ($task = $consumer->waitTask()) {
    try {
        
        
        // Simple logging logic: log the payload of each task to a file
        $logFile = __DIR__ . '/worker.log';
        $payload = $task->getPayload();
        $logEntry = sprintf("[%s] Received task: %s\n", date('Y-m-d H:i:s'), json_encode($payload));
        file_put_contents($logFile, $logEntry, FILE_APPEND);

        $task->complete();
    } catch (\Throwable $e) {
        $task->fail($e, $shouldBeRestarted);
    }
}


// require __DIR__ . '/vendor/autoload.php';

// use Nyholm\Psr7\Response;
// use Nyholm\Psr7\Factory\Psr17Factory;

// use Spiral\RoadRunner\Worker;
// use Spiral\RoadRunner\Http\PSR7Worker;
// $worker = Worker::create();

// $factory = new Psr17Factory();

// $psr7 = new PSR7Worker($worker, $factory, $factory, $factory);

// while (true) {
//     try {
//         $request = $psr7->waitRequest();
//         if ($request === null) {
//             break;
//         }
//     } catch (\Throwable $e) {
//         $psr7->respond(new Response(400));
//         continue;
//     }

//     try {
//         $psr7->respond(new Response(200, [], 'Hello RoadRunner!'));
//     } catch (\Throwable $e) {
//         $psr7->respond(new Response(500, [], 'Something Went Wrong!'));
//         $psr7->getWorker()->error((string)$e);
//     }
// } 
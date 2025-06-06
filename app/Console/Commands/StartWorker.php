<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class StartWorker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'machine:start {id : the ID of the machine to be started.}';

    protected $description = "This command starts a Fly.io machine. It needs the machine's ID as input.";

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $flyApiHostname = "http://_api.internal:4280";
        $flyAuthToken = env("FLY_API_TOKEN");
        $flyAppName = env("FLY_APP_NAME");
        $machineId = $this->argument('id');

        $response = Http::withHeaders([
            'Authorization' => "Bearer $flyAuthToken",
            'Content-Type' => 'application/json',
        ])->post("$flyApiHostname/v1/apps/$flyAppName/machines/$machineId/start");


        if ($response->failed()) {
            Log::error('Failed to start the machine: ' . $response->body());
            $this->error('Failed to start machine: ' . $response->body());
            return Command::FAILURE;
        }

        Log::info('Successfully started machine: ' . $response->body());
        $this->info('Machine started successfully: ' . $response->body());

        return Command::SUCCESS;
    }
}

<?php

namespace App\Jobs;

use App\Mailers\AppMailer;
use App\Models\MaintenanceSent;
use App\Models\SubscribeComponents;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\Queue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MaintenanceNewAlert implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private  $schedule_id;
    private  $components_to_sent;
    private  $data_pass;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($schedule_id, $components_to_sent, $data_pass)
    {
        $this->schedule_id = $schedule_id;
        $this->components_to_sent = $components_to_sent;
        $this->data_pass = $data_pass;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(AppMailer $mailer)
    {

        $subscribe_components = SubscribeComponents::with('subscribes')->whereIn('subscribes_components.components_id', $this->components_to_sent)->groupBy('subscribes_components.subscribes_id')->get();
        $email_sent = 0;


        foreach ( $subscribe_components as $subscribe_component )
        {

            if( empty($subscribe_component->subscribes->email) )
            {
                continue;
            }

            $subscribe_email_code = $subscribe_component->subscribes->code;

            $mailer->sendMaintenanceNewAlert($subscribe_component->subscribes->email, $this->data_pass, $subscribe_email_code);

            $created_at = date('Y-m-d H:i:s');

            $values = [
                'subscribes_id' => $subscribe_component->subscribes_id,
                'scheduled_id' =>  $this->schedule_id,
                'email' => $subscribe_component->subscribes->email,
                'created_at' => $created_at,
                'updated_at' => $created_at
            ];


            MaintenanceSent::insert($values);
            $email_sent++;

            if( $email_sent % $this->data_pass['bulk_emails']  == 0 )
            {
                //after we sent bulk_emails email sleep bulk_emails_sleep seconds
                sleep($this->data_pass['bulk_emails_sleep']);
            }

        }

    }

    public function failed(\Exception $exception)
    {
        // Send user notification of failure, etc...
        //var_dump($exception->getMessage());

        Queue::failing(function (JobFailed $event) {
            $event->connectionName;
            $event->job;
            $event->exception;
        });
    }
}

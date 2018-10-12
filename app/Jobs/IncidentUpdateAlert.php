<?php

namespace App\Jobs;

use App\Mailers\AppMailer;
use App\Models\SubscribeComponents;
use App\Models\SubscribesSent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\Queue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class IncidentUpdateAlert implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private  $incident_id;
    private  $components_to_sent;
    private  $data_pass;
    private  $incident_update_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($incident_id, $incident_update_id, $components_to_sent, $data_pass)
    {
        $this->incident_id = $incident_id;
        $this->incident_update_id = $incident_update_id;
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

            $mailer->sendIncidentUpdateAlert($subscribe_component->subscribes->email, $this->data_pass, $subscribe_email_code);

            $values = [
                'subscribes_id' => $subscribe_component->subscribes_id,
                'email' => $subscribe_component->subscribes->email,
                'incident_id' =>  $this->incident_id,
                'incident_updated_id' => $this->incident_update_id,
            ];

            SubscribesSent::insert($values);
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

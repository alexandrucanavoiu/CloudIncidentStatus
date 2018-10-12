<?php

namespace App\Mailers;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Mail\Mailer;

class AppMailer
{
    use Queueable, SerializesModels;

    protected $mailer;
    protected $fromAddress;
    protected $fromName;
    protected $to;
    protected $subject;
    protected $view;
    protected $data = [];

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function sendConfirmationSubscribe($code, $email, $from_address, $from_name, $title_app, $code_security)
    {
        $this->fromAddress = $from_address;
        $this->fromName = $from_name;
        $this->to = $email;
        $this->subject = "[Status Incidents] Confirm your subscription";
        $this->view = 'emails.subscribe';
        $this->data = compact('code', 'email', 'title_app', 'code_security');

        return $this->deliver();
    }

    public function sendConfirmationUnSubscribe($code, $email, $from_address, $from_name, $title_app, $code_security)
    {
        $this->fromAddress = $from_address;
        $this->fromName = $from_name;
        $this->to = $email;
        $this->view = 'emails.cancel-subscribe';
        $this->subject = "[Status Incidents] Confirm your unsubscription";
        $this->data = compact('code', 'email', 'title_app', 'code_security');

        return $this->deliver();
    }

    public function sendIncidentNewAlert($email, $data_pass, $subscribe_email_code)
    {
        $this->fromAddress = $data_pass['from_address'];
        $this->fromName = $data_pass['from_name'];
        $this->to = $email;
        $this->subject = "[Incident] " . $data_pass['incident_title'];
        $this->view = 'emails.incident-alert';
        $this->data = compact('email', 'data_pass', 'subscribe_email_code');

        return $this->deliver_incident_alert();
    }

    public function sendIncidentUpdateAlert($email, $data_pass, $subscribe_email_code)
    {
        $this->fromAddress = $data_pass['from_address'];
        $this->fromName = $data_pass['from_name'];
        $this->to = $email;
        $this->subject = "[Incident] " . $data_pass['incident_title'];
        $this->view = 'emails.incident-alert-update';
        $this->data = compact('email', 'data_pass', 'subscribe_email_code');

        return $this->deliver_incident_alert();
    }

    public function sendErrorQueueAlert($email, $from_name, $title_app, $error_message)
    {
        $this->fromAddress = $email;
        $this->fromName = $from_name;
        $this->to = $email;
        $this->subject = "[Error Jobs] " . $title_app;
        $this->view = 'emails.incident-alert';
        $this->data = compact('title_app', 'error_message');

        return $this->deliver_incident_alert();
    }

    public function sendMaintenanceNewAlert($email, $data_pass, $subscribe_email_code)
    {

        $this->fromAddress = $data_pass['from_address'];
        $this->fromName = $data_pass['from_name'];
        $this->to = $email;
        $this->subject = "[Maintenance] " . $data_pass['scheduled_title'];
        $this->view = 'emails.maintenance-new';
        $this->data = compact('email', 'data_pass', 'subscribe_email_code');

        return $this->deliver_incident_alert();
    }

    public function deliver()
    {

        $this->mailer->send($this->view, $this->data, function ($message) {
            $message->from($this->fromAddress, $this->fromName)
                ->to($this->to)->subject($this->subject);

        });
    }

    public function deliver_incident_alert()
    {

        $this->mailer->send($this->view, $this->data, function ($message) {
            $message->from($this->fromAddress, $this->fromName)
                ->to($this->to)->subject($this->subject);

        });
    }



}

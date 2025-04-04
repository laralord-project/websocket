<?php

namespace App\Mail\Traits;

use App\Models\Email;
use App\Models\EmailTemplate;
use Twig;

trait Templatable
{
    /**
     * @var \App\Models\EmailTemplate
     */
    public EmailTemplate $template;


    /**
     * @param array $data
     *
     * @return string
     */
    public function renderTemplate(array $data): string
    {
        $email = Email::where('namespace', get_called_class())->first();

        if (!$email) {
            \Log::error("Email " . get_called_class() . " is not registered on database");
        } else {
            // TODO: refactor to select the templates only with user's language
            /** @var EmailTemplate $template */
            $template = $email->templates()->first();
        }

        if (isset($template)) {
            $this->template = $template;
            $html = Twig::createTemplate($template->body)->render($data);
        } else {
            $html = view($this->view)->render($data);
        }

        return $html;
    }


    public function sendFromTemplate($data)
    {
        $html = $this->renderTemplate($data);

        return $this->subject($this->template->subject)->html($html);
    }
}

<?php

class mailSend extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('admin/mail_model');
        $this->load->library('email');
        $this->load->helper('functions_helper');
    }

    function index() {

        $data = $this->mail_model->get_mail_queue();
  
        foreach ($data as $email) {
            echo "<hr /> DE :" . $email->localEmail;
            echo "<br /> A :" . $email->visitorEmail;
            echo "<br /> Missatge :" . $email->message;
            $this->email->from("noreply@futsal.cat", "Federació Catalana de Futbol Sala");
            //$this->email->to($email->visitorEmail);
            $this->email->to('web@futsal.cat');
            //$this->email->cc('another@another-example.com');
            //$this->email->bcc('them@their-example.com');
            $this->email->subject($email->subject);
            $message = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
    <head>
        <meta http-equiv=\"Content-Type\" content=\"text/html; charset=ISO-8859-1\"/>
        <title>Mail</title>
        <style>body{ background-color:#ddd; font-family:Arial, Verdana; margin:0; padding:0; font-size:14px; color:#646464;}
        .section{font-size:16px; font-weight: bold; padding:20px 0 10px 10px; border-bottom:1px solid #ccc; margin-bottom:5px; margin-top:20px; color:#000;}
        .title{font-weight:bold; font-size:14px; color:#3b3b3b;}
        .content, .footer{font-size:14px; color:#666; padding:20px 0; font-weight: normal;}
        .content a{color:#0084BA;}
        .footer{font-size:12px;}
        </style>
    </head>
    <body>
        <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">
            <tr>
                <td width=\"20\">&nbsp;</td>
                <td align=\"center\" width=\"640\" >
                    <table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
                        <tr>
                            <!--Capcçalera-->
                            <td style=\"background-color:#f2f2f2; border:1px solid #ccc; border-top:0;\">
                                <table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
                                    <tr>
                                    <td width=20>&nbsp;</td>
                                        <td width=\"80\" align=\"center\" style=\"padding:10px 0;\" >
                                            <!-- <img src=\"http://www.futsal.cat/webImages/clubsImages/EFSRipoll.png\" width=\"80\" height=\"80\" />-->
                                            &nbsp;<img src=\"http://v3.futsal.cat/webImages/logoPetit.png\" width=\"80\" height=\"80\" />
                                        </td>
                                         <td width=20>&nbsp;</td>
                                        <td width=\"440\">
                                            <span style=\"font-weight: bold;font-size:16px; color:#000;\">" . $email->senderName . "</span>,<br />
                                            <span style=\"color:#9b9b9b9; font-size:14px;\">Notificacions de la Federaci&#243; Catalana de Futbol Sala.</span>
                                        </td>
                                        <td width=\"80\" align=\"center\" style=\"padding:10px;\" >
                                            <!--<img src=\"http://www.futsal.cat/webImages/logoPetit.png\" width=\"50\" height=\"50\" />-->
                                            &nbsp;

                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <!--Continguts-->
                            <td style=\"background-color:#fff; border:1px solid #ccc; border-top:0;\">
                                <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
                                    <td width=\"80\">&nbsp;</td>
                                    <td width=\"480\"><br /><br />
                                       
                                        " . $email->message . " 

                                    </td>
                                    <td width=\"50\">&nbsp;</td>
                                    </tr>
                                     <tr><td>&nbsp;</td></tr>
                                     <tr><td>&nbsp;</td></tr>
                                     <tr><td>&nbsp;</td></tr>
                                </table>
                            </td>
                           
                         </tr>
                         <tr>
                             <!--Cul-->

                            <td style=\"background-color:#eee; border:1px solid #ccc; border-top:0;\">
                              <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
                                   <tr>
                                   <td width=\"80\">&nbsp;</td>
                                    <td width=\"480\" class=\"footer\">
                                    <div class=\"footer\" style=\"font-size:11px;padding:10px;\">";
            
            $message .=" Federacio Catalana de Futbol Sala  <br />C/Guipuscoa 23-25 5&#232; D 08018 Barcelona<br />

Tel. 93 244 44 03 &bull; Fax 93 247 34 83 futsal@futsal.cat</div>
                                    </td>
                                    <td width=\"80\">&nbsp;</td>
                                    </tr>
                                   </table>
                            </td>
                        </tr>
                    </table>


                </td>
                <td width=\"100\">&nbsp;</td>
            </tr>
        </table>
    </body>
</html>";
          //  $this->email->message($message);
          //  $this->email->send();
          //  $this->mail_model->mark_as_send($email->id);
        }
    }

}

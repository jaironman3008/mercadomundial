<?php

/*
 * @author : nicolas Lattuada 
 * send emails with pdf attachment
 */

class AttachMailer{
    
    private $from, $to, $subject, $mess, $hash, $output;
    private $documents = Array();
    
    /*
     * @params from: adresse de l'envoyeur(+reponse)
     *            to : adresse a qui on envoie
     *            subject : le sujet du message
     *            mess : le message lui meme(format html)
     */
    function __construct($_from, $_to, $_subject, $_mess){
        $this->from = $_from;
        $this->to = $_to;
        $this->subject = $_subject;
        $this->mess = $_mess;
        $this->hash = md5(date('r', time()));
    }
    
    /*
     * @params url du document ajout
     */    
    public function attachFile($url, $name = ""){
        $attachment = chunk_split(base64_encode(file_get_contents($url)));
        $docName    = $name == "" ? basename($url) : $name;
        $randomHash = $this->hash;
        $docOutput = "--PHP-alt-$randomHash--rnrn"
                     ."--PHP-mixed-$randomHashrn"
                     ."Content-Type: application/pdf; name=".$docName." rn"
                     ."Content-Transfer-Encoding: base64 rn"
                     ."Content-Disposition: attachment rnrn"
                     .$attachment . "rn";
        $this->documents[] = $docOutput;
    }
    
    private function makeMessage(){
        $randomHash = $this->hash;
        $messageOutput = "--PHP-mixed-$randomHashrn"
                         ."Content-Type: multipart/alternative; boundary=PHP-alt-$randomHashrnrn"
                         ."--PHP-alt-$randomHashrn"
                         ."Content-Type: text/plain; charset='iso-8859-1'rn"
                         ."Content-Transfer-Encoding: 7bitrnrn"
                         .$this->mess . "rnrn"
                         ."--PHP-alt-$randomHashrn"
                         ."Content-Type: text/html; charset='iso-8859-1'rn"
                         ."Content-Transfer-Encoding: 7bitrnrn"
                         . $this->mess . "rn";
                         
        foreach($this->documents as $document){
            $messageOutput .= $document; 
        }
        $messageOutput .="--PHP-mixed-$randomHash;--";
        $this->output = $messageOutput;
    }
    
    public function send(){
        $this->makeMessage();
        $from = $this->from;
        $randomHash = $this->hash;
        $headers = "From: $fromrnReply-To: $from";
        $headers .= "rnContent-Type: multipart/mixed; boundary=".PHP-mixed-$randomHash."";
        $mail_sent = @mail( $this->to, $this->subject, $this->output, $headers );
        return $mail_sent ? true : false;
    }
    
}/*
$mailer = new AttachMailer("facturacion@mercadomundial.esy.es", "jaironman_jcs@hotmail.com", "Su Factura", "Le enviamos su factura");
$mailer->attachFile("../facturasPdf/prueba.pdf");
//$mailer->send() ? echo"Enviado": echo"Problema al enviar";
if($mailer->send()==true)echo"Enviado";else echo"Problema al enviar";*/

$para = "jaironman_jcs@hotmail.com";
$titulo = "El título del correo";
$mensaje = "Mensaje enviado en fecha ".date('d/m/y')." a horas ".date('H:i:s')."\r\n Saludos"; //Mensaje de 2 lineas
$cabeceras = "From: facturacion@mercadomundial.esy.es" . "\r\n" . //La direccion de correo desde donde supuestamente se envió
    "Reply-To: facturacion@mercadomundial.esy.es" . "\r\n" . //La direccion de correo a donde se responderá (cuando el recepto haga click en RESPONDER)
    "X-Mailer: PHP/" . phpversion();  //información sobre el sistema de envio de correos, en este caso la version de PHP
 
mail($para, $titulo, $mensaje, $cabeceras);
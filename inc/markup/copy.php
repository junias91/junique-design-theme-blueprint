<?php 

function add_copy_to_header(){
echo <<<EOT
<!-- 
░░░░░██╗██╗░░░██╗███╗░░██╗██╗░██████╗░██╗░░░██╗███████╗░░░██████╗░███████╗░██████╗██╗░██████╗░███╗░░██╗
░░░░░██║██║░░░██║████╗░██║██║██╔═══██╗██║░░░██║██╔════╝░░░██╔══██╗██╔════╝██╔════╝██║██╔════╝░████╗░██║
░░░░░██║██║░░░██║██╔██╗██║██║██║██╗██║██║░░░██║█████╗░░░░░██║░░██║█████╗░░╚█████╗░██║██║░░██╗░██╔██╗██║
██╗░░██║██║░░░██║██║╚████║██║╚██████╔╝██║░░░██║██╔══╝░░░░░██║░░██║██╔══╝░░░╚═══██╗██║██║░░╚██╗██║╚████║
╚█████╔╝╚██████╔╝██║░╚███║██║░╚═██╔═╝░╚██████╔╝███████╗██╗██████╔╝███████╗██████╔╝██║╚██████╔╝██║░╚███║
░╚════╝░░╚═════╝░╚═╝░░╚══╝╚═╝░░░╚═╝░░░░╚═════╝░╚══════╝╚═╝╚═════╝░╚══════╝╚═════╝░╚═╝░╚═════╝░╚═╝░░╚══╝     

JUNIQUE Design
https://junique.design

Junias Fenske
hi@junique.design

JUNIQUE Design ist eine Agentur für Webdesign aus Bonn.
Wir haben uns auf die Erstellung funktionaler und schicker Webseiten spezialisiert.
Gerne kümmern wir uns auch um SEO, Webseitenpflege und Content Management.
Wenn Sie Fragen haben oder ein Projekt mit uns starten möchten, dann kontaktieren Sie uns gerne.
-->

EOT;
}
add_action( 'header_top', 'add_copy_to_header' );
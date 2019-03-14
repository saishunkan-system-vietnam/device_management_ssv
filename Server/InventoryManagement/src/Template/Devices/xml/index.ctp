<?php
$xml = Xml::fromArray(['response' => $devices]);
echo $xml->asXML();

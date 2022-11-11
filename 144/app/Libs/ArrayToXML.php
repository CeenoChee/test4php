<?php

namespace App\Libs;

class ArrayToXML
{
    private $version;
    private $encoding;

    public function __construct($xmlVersion = '1.0', $xmlEncoding = 'UTF-8')
    {
        $this->version = $xmlVersion;
        $this->encoding = $xmlEncoding;
    }

    public function buildXML($data, $startElement = 'data')
    {
        if (! is_array($data)) {
            $err = 'Invalid variable type supplied, expected array not found on line ' . __LINE__ . ' in Class: ' . __CLASS__ . ' Method: ' . __METHOD__;
            trigger_error($err);

            return false; // return false error occurred
        }

        $xml = new \XMLWriter();
        $xml->openMemory();
        $xml->startDocument($this->version, $this->encoding);
        $xml->startElement($startElement);
        $data = $this->writeAttr($xml, $data);
        $this->writeEl($xml, $data);
        $xml->endElement(); // write end element
        // returns the XML results
        return $xml->outputMemory(true);
    }

    public function download($data, $startElement = 'data')
    {
        header('Content-type: text/xml');
        echo $this->buildXML($data, $startElement);

        exit;
    }

    protected function writeAttr(\XMLWriter $xml, $data)
    {
        if (is_array($data)) {
            $nonAttributes = [];
            foreach ($data as $key => $val) {
                // handle an attribute with elements
                if ($key[0] == '@') {
                    $xml->writeAttribute(substr($key, 1), $val);
                } elseif ($key[0] == '%') {
                    if (is_array($val)) {
                        $nonAttributes = $val;
                    } else {
                        $xml->text($val);
                    }
                } elseif ($key[0] == '#') {
                    if (is_array($val)) {
                        $nonAttributes = $val;
                    } else {
                        $xml->startElement(substr($key, 1));
                        $xml->writeCData($val);
                        $xml->endElement();
                    }
                } elseif ($key[0] == '!') {
                    if (is_array($val)) {
                        $nonAttributes = $val;
                    } else {
                        $xml->writeCData($val);
                    }
                }
                // ignore normal elements
                else {
                    $nonAttributes[$key] = $val;
                }
            }

            return $nonAttributes;
        }

        return $data;
    }

    protected function writeEl(\XMLWriter $xml, $data)
    {
        foreach ($data as $key => $value) {
            if (is_array($value) && ! $this->isAssoc($value)) { // numeric array
                foreach ($value as $itemValue) {
                    if (is_array($itemValue)) {
                        $xml->startElement($key);
                        $itemValue = $this->writeAttr($xml, $itemValue);
                        $this->writeEl($xml, $itemValue);
                        $xml->endElement();
                    } else {
                        $itemValue = $this->writeAttr($xml, $itemValue);
                        $xml->writeElement($key, "{$itemValue}");
                    }
                }
            } elseif (is_array($value)) { // associative array
                $xml->startElement($key);
                $value = $this->writeAttr($xml, $value);
                $this->writeEl($xml, $value);
                $xml->endElement();
            } else { // scalar
                $value = $this->writeAttr($xml, $value);
                $xml->writeElement($key, "{$value}");
            }
        }
    }

    protected function isAssoc($array)
    {
        return (bool) count(array_filter(array_keys($array), 'is_string'));
    }
}

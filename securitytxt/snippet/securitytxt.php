<?php

include_once './conf/config.php';

$expires = gmdate("Y-m-d\TH:i:s\Z", strtotime("+1 year"));

$canonicaltxt = "# Canonical URL\nCanonical: https://$host$uri\n\n";

if (isset($contact)) {
    if (!empty($contact)) {
        if (is_array($contact)) {
            $contacttxt = "# Our security address\nContact: " . implode("\nContact: ", $contact) . "\n\n";
        } else {
            $contacttxt = "# Our OpenPGP key\nEncryption: $contact\n\n";
        }
    } else {
        $contacttxt = "";
    }
} else {
    $contacttxt = "";
}

if (isset($policy)) {
    if (!empty($policy)) {
        if (is_array($policy)) {
            $policytxt = "# Our security policy\nPolicy: " . implode("\nPolicy: ",$policy) . "\n\n";
        } else {
            $policytxt = "# Our security policy\nPolicy: $policy\n\n";
        }
    } else {
        $policytxt = "";
    }
} else {
    $policytxt = "";
}

if (isset($acknowledgments)) {
    if (!empty($acknowledgments)) {
        if (is_array($acknowledgments)) {
            $acknowledgmentstxt = "# Hall of fame\nAcknowledgments: " . implode("\nAcknowledgments: ", $acknowledgments) . "\n\n";
        } else {
            $acknowledgmentstxt = "# Hall of fame\nAcknowledgments: $acknowledgments\n\n";
        }
    } else {
        $acknowledgmentstxt = "";
    }
} else {
    $acknowledgmentstxt = "";
}

if (isset($hiring)) {
    if (!empty($hiring)) {
        if (is_array($hiring)) {
            $hiringtxt = "# Jobs for you\nHiring: " . implode("\nHiring: ",$hiring) . "\n\n";
        } else {
            $hiringtxt = "# Jobs for you\nHiring: $hiring\n\n";
        }
    } else {
        $hiringtxt = "";
    }
} else {
    $hiringtxt = "";
}

$langtxt = "# These are the languages we speak\nPreferred-Languages: $lang\n\n";

if (isset($encryption)) {
    if (!empty($encryption)) {
        if (is_array($encryption)){
            $encryptiontxt = "# Our OpenPGP key\nEncryption: " . implode("\nEncryption: ", $encryption) . "\n\n";
        } else {
            $encryptiontxt = "# Our OpenPGP key\nEncryption: $encryption\n\n";
        }
    } else {
        $encryptiontxt = "";
    }
} else {
    $encryptiontxt = "";
}

$expirestxt = "# You shouldn't trust this file, once it has expired (like bad milk)\nExpires: $expires\n\n";

$securitytxt = "$canonicaltxt$contacttxt$policytxt$acknowledgmentstxt$hiringtxt$langtxt$encryptiontxt$expirestxt";

?>

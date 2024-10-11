<?php
$domain = "staffed.com";

// A records
$aRecords = dns_get_record($domain, DNS_A);
echo "A records:\n";
echo json_encode($aRecords);

// AAAA records
$aaaaRecords = dns_get_record($domain, DNS_AAAA);
echo "AAAA records:\n";
echo json_encode($aaaaRecords);

// TXT records
$txtRecords = dns_get_record($domain, DNS_TXT);
echo "TXT records:\n";
echo json_encode($txtRecords);

// CNAME records
$cnameRecords = dns_get_record($domain, DNS_CNAME);
echo "CNAME records:\n";
echo json_encode($cnameRecords);

// NS records
$nsRecords = dns_get_record($domain, DNS_NS);
echo "NS records:\n";
echo json_encode($nsRecords);

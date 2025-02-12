# mDL PHP library

## Description

Library to manage the interactions with Blerify API

## Setup

- In your project ensure you have a folder named "config" which should contain your service account generated from Blerify Portal.

## Examples

### Create an the mDL derived message to sign

```php
<?php

require 'vendor/autoload.php';

use Blerify\Authentication\JwtHandler;
use Blerify\Licenses\MdlClient;
use Blerify\Model\Request\AdditionalData;
use Blerify\Model\Request\Assemble;
use Blerify\Model\Request\Create;
use Blerify\Model\Request\OrganizationUser;
use Blerify\Model\Request\MdlData;
use Blerify\Model\Request\Sign;
use Ramsey\Uuid\Uuid;

// Input variables
$baseEndpoint = 'https://api.blerify.com';

$projectId = '7c37e269-56fa-4e38-85fc-707075fcf968';
$templateId = '1a58e41e-6f0b-4dff-a277-a2cd0ad9ea1a';

// Initialize JWT handler
$jwtHandler = JwtHandler::new(__DIR__ . '/config/credentials.json');

// Initialize Mdl client
$mdlClient = new MdlClient($baseEndpoint, $jwtHandler, $projectId);

// Step 1: Create an unsigned mDL and signing message
echo "\n1. Create signing message: ";
$portrait = 'FFD8FFE000104A46494600010101009000900000FFDB004300130D0E110E0C13110F11151413171D301F1D1A1A1D3A2A2C2330453D4947443D43414C566D5D4C51685241435F82606871757B7C7B4A5C869085778F6D787B76FFDB0043011415151D191D381F1F38764F434F7676767676767676767676767676767676767676767676767676767676767676767676767676767676767676767676767676FFC00011080018006403012200021101031101FFC4001B00000301000301000000000000000000000005060401020307FFC400321000010303030205020309000000000000010203040005110612211331141551617122410781A1163542527391B2C1F1FFC4001501010100000000000000000000000000000001FFC4001A110101010003010000000000000000000000014111213161FFDA000C03010002110311003F00A5BBDE22DA2329C7D692BC7D0D03F52CFB0FF75E7A7EF3E7709723A1D0DAE146DDFBB3C039CE07AD2BD47A7E32DBB8DD1D52D6EF4B284F64A480067DFB51F87FFB95FF00EB9FF14D215DE66AF089CE44B7DBDE9CB6890A2838EDDF18078F7ADD62D411EF4DB9B10A65D6B95A147381EA0D495B933275FE6BBA75C114104A8BA410413E983DFF004F5AF5D34B4B4CDE632D0BF1FD1592BDD91C6411F3934C2FA6AF6B54975D106DCF4A65AE56E856001EBC03C7CE29DD9EEF1EF10FC447DC9DA76AD2AEE93537A1BA7E4F70DD8EFF0057C6DFFB5E1A19854A83758E54528750946EC6704850CD037BCEB08B6D7D2CC76D3317FC7B5CC04FB6707269C5C6E0C5B60AE549242123B0E493F602A075559E359970D98DB89525456B51C951C8AFA13EA8E98E3C596836783D5C63F5A61A99FDB7290875DB4BE88AB384BBBBBFC7183FDEAA633E8951DB7DA396DC48524FB1A8BD611A5AA2A2432F30AB420A7A6D3240C718CF031FA9EF4C9AD550205AA02951DF4A1D6C8421B015B769DB8C9229837EA2BE8B1B0D39D0EBA9C51484EFDB8C0EFD8D258DAF3C449699F2EDBD4584E7AF9C64E3F96B9BEB28D4AC40931E6478C8E76A24A825449501D867D2B1DCDEBAE99B9C752AE4ECD6DDE4A179C1C1E460938F9149EF655E515C03919A289CB3DCA278FB7BF177F4FAA829DD8CE3F2AC9A7ECDE490971FAFD7DCE15EED9B71C018C64FA514514B24E8E4F8C5C9B75C1E82579DC1233DFEC08238F6ADD62D391ACC1C5256A79E706D52D431C7A0145140B9FD149EB3A60DC5E88CBBC2DA092411E9DC71F39A7766B447B344E847DCAC9DCB5ABBA8D145061D43A6FCF1E65CF15D0E90231D3DD9CFE62995C6DCC5CA12A2C904A15F71DD27D451453E09D1A21450961CBB3EA8A956433B781F1CE33DFED54F0E2B50A2B71D84ED6DB18028A28175F74FC6BDA105C529A791C25C4F3C7A11F71586268F4A66B726E33DE9EA6F1B52B181C760724E47B514520A5A28A283FFD9';
$mdlData = MdlData::new()->familyName('Maravi')->givenName('Carlos')->birthDate('1987-03-15')
->issueDate('2023-09-01')->expiryDate('2028-09-30')->issuingCountry('US')->issuingAuthority('Sertracen')
->documentNumber('8-203-1365')->portrait($portrait)->drivingPrivileges([])->unDistinguishingSign('PA');
$devicePublicKey = '{
    "kty":"EC",
    "x":"iBh5ynojixm_D0wfjADpouGbp6b3Pq6SuFHU3htQhVk",
    "y":"oxS1OAORJ7XNUHNfVFGeM8E0RQVFxWA62fJj-sxW03c",
    "crv": "P-256"
}';
$additionalData = AdditionalData::new()->mdlData($mdlData)->devicePublicKey(json_decode($devicePublicKey));
$organizationUser = OrganizationUser::new()->id('8-203-1365')->did('did:lac1:1iT5g9gduT4Q5DWE2bnncfnBCnM9uXPWMrCTvhPf2a8wpHWJgFBEZn295t1h9ucnQyvJ');
$createRequest = Create::new()->templateId($templateId)->additionalData($additionalData)->organizationUser($organizationUser);
$correlationId = Uuid::uuid4()->toString();

$createResponse = $mdlClient->create($createRequest, $correlationId);
handleError($createResponse);
echo "Ok\n";

// Step 2: Call to sign (ONLY FOR TESTING, do not use for production)
echo "\n2. Calling API to sign Message: ";
$signingMessage = $createResponse->getSigningMessage();
$issuerSigningJwk = "{\"kty\": \"EC\",\"kid\": \"11\",\"x\": \"iTwtg0eQbcbNabf2Nq9L_VM_lhhPCq2s0Qgw2kRx29s\",\"y\": \"YKwXDRz8U0-uLZ3NSI93R_35eNkl6jHp6Qg8OCup7VM\",\"crv\": \"P-256\",\"d\": \"o6PrzBm1dCfSwqJHW6DVqmJOCQSIAosrCPfbFJDMNp4\"}";
$signingRequest = Sign::new()->signingMessage($signingMessage)->jwk($issuerSigningJwk);
$signResponse = $mdlClient->signTest($signingRequest, $correlationId);
handleError($signResponse);
echo "Ok\n";
// echo "\nSign Response: " . $signResponse->getSignature() . "\n" ;

// Step 3: Assemble response
echo "\n3. Assemble final mDL: ";
$pemIssuerCertificate = "-----BEGIN CERTIFICATE-----MIICKjCCAdCgAwIBAgIUV8bM0wi95D7KN0TyqHE42ru4hOgwCgYIKoZIzj0EAwIwUzELMAkGA1UEBhMCVVMxETAPBgNVBAgMCE5ldyBZb3JrMQ8wDQYDVQQHDAZBbGJhbnkxDzANBgNVBAoMBk5ZIERNVjEPMA0GA1UECwwGTlkgRE1WMB4XDTIzMDkxNDE0NTUxOFoXDTMzMDkxMTE0NTUxOFowUzELMAkGA1UEBhMCVVMxETAPBgNVBAgMCE5ldyBZb3JrMQ8wDQYDVQQHDAZBbGJhbnkxDzANBgNVBAoMBk5ZIERNVjEPMA0GA1UECwwGTlkgRE1WMFkwEwYHKoZIzj0CAQYIKoZIzj0DAQcDQgAEiTwtg0eQbcbNabf2Nq9L/VM/lhhPCq2s0Qgw2kRx29tgrBcNHPxTT64tnc1Ij3dH/fl42SXqMenpCDw4K6ntU6OBgTB/MB0GA1UdDgQWBBSrbS4DuR1JIkAzj7zK3v2TM+r2xzAfBgNVHSMEGDAWgBSrbS4DuR1JIkAzj7zK3v2TM+r2xzAPBgNVHRMBAf8EBTADAQH/MCwGCWCGSAGG+EIBDQQfFh1PcGVuU1NMIEdlbmVyYXRlZCBDZXJ0aWZpY2F0ZTAKBggqhkjOPQQDAgNIADBFAiAJ/Qyrl7A+ePZOdNfc7ohmjEdqCvxaos6//gfTvncuqQIhANo4q8mKCA9J8k/+zh//yKbN1bLAtdqPx7dnrDqV3Lg+-----END CERTIFICATE-----";
$assembleRequest = Assemble::new()->templateId($templateId)->signature($signResponse->getSignature())->kid("11")->certificate($pemIssuerCertificate);
$assebleResponse = $mdlClient->assemble($assembleRequest, $createResponse->getCredential()->getId(), $correlationId);
handleError($assebleResponse);
echo "Ok\n";
echo "mDL " .  $assebleResponse . "\n";


function handleError($response)
{
    if (is_array($response) && !empty($response['error'])) {
        // Handle the error
        echo "Error occurred: " . $response['message'] . " (Code: " . $response['code'] . ")\n";
        echo "Error details: " . json_encode($response['details']);
        exit;
    }
}
```

<?php

declare(strict_types=1);

namespace SAML2\Certificate;

use PHPUnit\Framework\TestCase;
use SAML2\CertificatesMock;
use SAML2\Certificate\PrivateKey;

class PrivateKeyTest extends TestCase
{
    /**
     * @group certificate
     * @test
     * @return void
     */
    public function test_create_from_key(): void
    {
        $key = CertificatesMock::getPlainPrivateKey();

        $pk_nopass = PrivateKey::create($key);
        $this->assertEquals($key, $pk_nopass->getKeyAsString());

        $pk_withpass = PrivateKey::create($key, "s3cr1t");
        $this->assertEquals($key, $pk_withpass->getKeyAsString());
        $this->assertEquals("s3cr1t", $pk_withpass->getPassphrase());
    }
}

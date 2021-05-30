<?php

use PHPUnit\Framework\TestCase;
use App\Entities\LinkdataEntity;

class LinkdataEntityTest extends TestCase {

    public $testData;
    public $testKey;

    public function setUp():void {
        $this->testKey = 'tests';
        $this->testData = array(
            'data_raw' => 'tests data',
            'data_encrypted' => '',
            'data_decrypted' => '',
            'expires' => '1981-03-06 16:20:00'
        );
    }

    public function testPopulate() {
        $LinkdataEntity = new LinkdataEntity();
        $LinkdataEntity->populate($this->testData);

        $data = $LinkdataEntity->getLinkdata();
        $this->assertArrayHasKey('data_raw', $data);
        $this->assertArrayHasKey('data_encrypted', $data);
        $this->assertArrayHasKey('data_decrypted', $data);
        $this->assertArrayHasKey('expires', $data);

        $this->assertEquals($this->testData['data_raw'], $LinkdataEntity->getRawLinkData());
        $this->assertEquals($this->testData['data_encrypted'], $LinkdataEntity->getEncryptedLinkData());
        $this->assertEquals($this->testData['data_decrypted'], $LinkdataEntity->getDecryptedLinkData());
        $this->assertEquals($this->testData['expires'], $LinkdataEntity->getExpires());

    }

    public function testSetEncryptionKey() {
        $LinkdataEntity = new LinkdataEntity();
        $LinkdataEntity->setEncryptionKey($this->testKey);
        $this->assertEquals($LinkdataEntity->getEncryptionKey(), $this->testKey);
    }

    public function testLinkIsNotExpired() {
        $LinkdataEntity = new LinkdataEntity();
        $LinkdataEntity->populate($this->testData);

        $LinkdataEntity->setExpires('2090-03-06 16:20:00');
        $this->assertFalse($LinkdataEntity->linkIsExpired());
    }

    public function testLinkIsExpired() {
        $LinkdataEntity = new LinkdataEntity();
        $LinkdataEntity->populate($this->testKey);

        $LinkdataEntity->setExpires('1981-03-06 16:20:00');
        $this->assertTrue($LinkdataEntity->linkIsExpired());
    }

    public function testSanitizeRawLinkdata() {
        $LinkdataEntity = new LinkdataEntity();
        $LinkdataEntity->setRawLinkData('<h1>hello</h1>');

        $this->assertEquals(
            '&#60;h1&#62;hello&#60;/h1&#62;',
            $LinkdataEntity->sanitizeRawLinkdata());
    }

    /*
    public function testEncrypt() {
        self::bootKernel();
        $container = self::$container;

        $linkdataEntity = $container->get(LinkdataEntity::class);
        $LinkdataEntity->encrypt('tests');
        $this->assertEquals('encoded', $LinkdataEntity->getEncryptedLinkData());
    }

    public function testDecrypt() {
        $LinkdataEntity = new LinkdataEntity();
        $LinkdataEntity->decrypt($this->testKey);
        $this->assertEquals('decoded', $LinkdataEntity->getDecryptedLinkData());
    }
    */
}

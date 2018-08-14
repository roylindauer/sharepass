<?php

namespace Royl\Sharepass\Helpers {
    function getService($service) {
        switch ($service) {
            case 'app.encrypt':
                return new AppEncrypt();
                break;
        }
        return true;
    }

    class AppEncrypt {
        public function setKey($key) {
            return true;
        }

        public function encode($str) {
            return 'encoded';
        }

        public function decode($str) {
            return 'decoded';
        }
    }
}

namespace Royl\Sharepass\Test {

    use PHPUnit\Framework\TestCase;
    use Royl\Sharepass\Entities\LinkdataEntity;

    class LinkdataEntityTest extends TestCase {

        public $testData;
        public $testKey;

        public function setUp() {
            $this->testKey = 'test';
            $this->testData = array(
                'data_raw' => 'test data',
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
            $LinkdataEntity->populate($this->testKey, $this->testData);

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

        public function testEncrypt() {
            $LinkdataEntity = new LinkdataEntity();
            $LinkdataEntity->encrypt('test');
            $this->assertEquals('encoded', $LinkdataEntity->getEncryptedLinkData());
        }

        public function testDecrypt() {
            $LinkdataEntity = new LinkdataEntity();
            $LinkdataEntity->decrypt($this->testKey);
            $this->assertEquals('decoded', $LinkdataEntity->getDecryptedLinkData());
        }
    }
}
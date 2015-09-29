<?php
namespace tests;

use Yii;
use ihacklog\rsa\ISecurityProvider;
use ihacklog\rsa\OpensslRSA;
use ihacklog\rsa\RSA;

class RSATest extends \PHPUnit_Framework_TestCase
{
    private $_rsa;

    private $_pkey = '';

    private $_pubKey = '';

    protected function setUp()
    {
        $this->_pkey = Yii::getAlias('@tests') . '/_data/rsa/p2p20140616.pem';
        $this->_pubKey =  Yii::getAlias('@tests') . '/_data/rsa/p2p20140616.cer';
        $privateKey =  $this->_pkey;
        $pubkey =  $this->_pubKey;
        $rsa = new RSA();
        $rsa->addProvider(new OpensslRSA());
        $rsa->setPrivateKeyFile($privateKey);
        $rsa->setPublicKeyFile($pubkey);
        $this->_rsa = $rsa;
    }

    protected function tearDown()
    {
    }

    // tests
    public function testPublicEnc()
    {

        $this->assertEquals($this->_rsa->privateDecrypt($this->_rsa->publicEncrypt('bar')), 'bar');
    }

    public function testPrivateEnc()
    {
        $this->assertEquals($this->_rsa->publicDecrypt($this->_rsa->privateEncrypt('foo')), 'foo');
    }

    public function testChineseDec()
    {
        $this->expectOutputString('乱码哥');
        $dec = $this->_rsa->privateDecrypt(hex2bin('A16BDA1E358EEF9479FB735120C6EAA9186432F10E401C214F54BA94ABF518556FE46C7766757D68A8FE3B734A493D1B0160C4F9DD7531CDE8796EDC0143DC7C7C3EE16E1D8AB4AC1F986E4EF9CC1A9D09BD0B452CC553479FB314E865CF9C119087B9C2C64847648EAF0FF8CCE7DD3EA871B34DE9F2A8913263094747BCEDD6'));
        print pack('H*', $dec);
    }

    public function testChineseEnc()
    {
        $enc = strtoupper(bin2hex($this->_rsa->publicEncrypt(strtoupper(unpack('H*', '乱码哥')[1]))));
        $dec = $this->_rsa->privateDecrypt(hex2bin($enc));
        $this->expectOutputString('乱码哥');
        print pack('H*', $dec);
    }



    public function testPrivateEncChinese()
    {
        $this->assertEquals($this->_rsa->publicDecrypt($this->_rsa->privateEncrypt('荒野无灯')), '荒野无灯');
    }

    public function testSign()
    {
        $plainText = '{"applyCode":"20140613105100120140704100241001","memberId":"P2PMem0014","merchantId":"201406131051001","transCode":"1002","trxDate":"20140704100241","version":"1.0"}';
        $md5       = strtoupper(md5($plainText));
        $sign = base64_encode($this->_rsa->sign($md5));
        $signEncoded = rawurlencode($sign);
        //$this->expectOutputString('9B50DBED01828D09D80AF27F458A14B4');
        //print $md5;
        $this->assertEquals($md5, '9B50DBED01828D09D80AF27F458A14B4');
        $this->assertEquals($sign, 'LGoFXHt534upp2MCgNeC8g84Fq7AwnyPcfu4yMgs8YKaaT4M8Cvv9RD6nwv3GPeEXSyv4+iO88N2XYQdk46qQdiin8+XEetTPnH/mKAtIDaqO4viED8h4g90ljcmpwmSjvTBB58qoulIE/qSrj4CzJJiNM0ke/YUGgClEgT5GY8=');
        $this->assertEquals($signEncoded, 'LGoFXHt534upp2MCgNeC8g84Fq7AwnyPcfu4yMgs8YKaaT4M8Cvv9RD6nwv3GPeEXSyv4%2BiO88N2XYQdk46qQdiin8%2BXEetTPnH%2FmKAtIDaqO4viED8h4g90ljcmpwmSjvTBB58qoulIE%2FqSrj4CzJJiNM0ke%2FYUGgClEgT5GY8%3D');
        //输出看看
        $this->expectOutputString('LGoFXHt534upp2MCgNeC8g84Fq7AwnyPcfu4yMgs8YKaaT4M8Cvv9RD6nwv3GPeEXSyv4+iO88N2XYQdk46qQdiin8+XEetTPnH/mKAtIDaqO4viED8h4g90ljcmpwmSjvTBB58qoulIE/qSrj4CzJJiNM0ke/YUGgClEgT5GY8=');
        print $sign;
        //$this->expectOutputString('LGoFXHt534upp2MCgNeC8g84Fq7AwnyPcfu4yMgs8YKaaT4M8Cvv9RD6nwv3GPeEXSyv4%2BiO88N2XYQdk46qQdiin8%2BXEetTPnH%2FmKAtIDaqO4viED8h4g90ljcmpwmSjvTBB58qoulIE%2FqSrj4CzJJiNM0ke%2FYUGgClEgT5GY8%3D');
        //print $signEncoded;
        $this->assertTrue($this->_rsa->verify($md5, base64_decode($sign)));
    }

    /**
     * 测试验签
     *
     * @return void
     */
    public function testPlatformSign()
    {
        $pubkey =  Yii::getAlias('@tests') . '/_data/rsa/TLgongyao.cer';
        $rsa = new RSA();
        $rsa->addProvider(new OpensslRSA());
        $rsa->setPublicKeyFile($pubkey);
        $plainText = '{"errorMsg":"提交成功","memberId":"201406205939508","pId":"98C1513A6A11B73E721104AFD8DC1C140E22872F1A5F19F7ED724BF9C2E54019231DBA80F36D02D4817F1946FDB927E26B7AF6D4553BA2EF0C1DC907CCB2B977EA1175431145C88CC8E2B42179567CBA1F109CC2BE101713DF9F2EBF091E68A232B77C0705A8310987105D0F3B2E2CD6A49BDD035FFBEAD57F3AA6D993815FFF","reqSn":"20140613105100120140704100241001","resSn":"201406131051001201407041002079610447","resTime":"20140704100207","retCode":"100000","trxCode":"1002","typesOfCertificate":"0","userName":"233C2F59A32F4554473BA4007C38F33875F71F63F652C8CB1BD95A776C919ED150CB6C49C2811A1A68CB8BC495B8BA8441087B0D172CE6B52C1A17A8CCFB81A7EF16E5E437860395439BCA95718A30D721DFDDD6627AE7AD9C9069F731270767F7D5F6DE012F28F240391A2454647B946716B6D3E07166CBB2DF2C6C150EA880","userStatus":"0","version":"1.0"}';
        $sign = 'pAG0DTY5uLPkNS9u0X373yFw5wYPM6jPgrMH6oUvvhmz0yrOSdbib2etSrA6HXOwULMn0SnDRfOdVWicL25/6yD/7ZXGU1ZhdAJgmh710GsMQ28mzZ+DlJ7TdKJOUiV5lC3jlzCXHlBOAk6nRLPw0eEd0l7uV6uEfHJiDyub1Kc=';
        $this->assertTrue($rsa->verify(strtoupper(md5($plainText)), base64_decode($sign)));
    }
}
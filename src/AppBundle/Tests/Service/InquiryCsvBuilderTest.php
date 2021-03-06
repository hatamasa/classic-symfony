<?php

use AppBundle\Entity\Inquiry;
use AppBundle\Entity\InquiryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Service\Csv\InquiryCsvBuilder;

class InquiryCsvBuilderTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var InquiryCsvBuilder
     */
    private $SUT;

    /**
     * @var InquiryRepository
     */
    private $inquiryRepository;

    /**
     * @test
     */
    public function CSVが正しく作られること()
    {
        $inquiry1 = new Inquiry();
        $inquiry1->setId(1);
        $inquiry1->setName('テストあいうえお');
        $inquiry1->setEmail('aiu@example.com');

        $inquiry2 = new Inquiry();
        $inquiry2->setId(2);
        $inquiry2->setName('テストかきく けこ');
        $inquiry2->setEmail('keko@example.com');
        $inquiryCollection = new ArrayCollection([$inquiry1, $inquiry2]);

        $this->inquiryRepository->expects($this->once())
        ->method('findAllByKeyword')
        ->willReturn($inquiryCollection);

        $result = $this->SUT->build('テスト');

        $expected = '1,テストあいうえお,aiu@example.com' . "\r\n" .
                    '2,"テストかきく けこ",keko@example.com' . "\r\n";

        $this->assertThat($result, $this->equalTo($expected));


    }

    protected function setUp()
    {
        $this->inquiryRepository = $this->getMockBuilder(InquiryRepository::class)
        ->disableOriginalConstructor()
        ->getMock();

        $this->SUT = new InquiryCsvBuilder('UTF-8', $this->inquiryRepository);
    }
}


<?php

declare(strict_types=1);

namespace SimpleSAML\Test\SAML2\XML\md;

use DOMDocument;
use PHPUnit\Framework\TestCase;
use SimpleSAML\Assert\AssertionFailedException;
use SimpleSAML\SAML2\Constants;
use SimpleSAML\SAML2\XML\md\AbstractLocalizedName;
use SimpleSAML\SAML2\XML\md\ServiceDescription;
use SimpleSAML\Test\XML\SerializableXMLTestTrait;
use SimpleSAML\XML\DOMDocumentFactory;

/**
 * Tests for localized names.
 *
 * @covers \SimpleSAML\SAML2\XML\md\ServiceDescription
 * @covers \SimpleSAML\SAML2\XML\md\AbstractLocalizedName
 * @covers \SimpleSAML\SAML2\XML\md\AbstractMdElement
 * @package simplesamlphp/saml2
 */
final class ServiceDescriptionTest extends TestCase
{
    use SerializableXMLTestTrait;


    /** @var array */
    protected array $arrayDocument;


    /**
     */
    protected function setUp(): void
    {
        $this->testedClass = ServiceDescription::class;

        $this->xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(dirname(dirname(dirname(__FILE__)))) . '/resources/xml/md_ServiceDescription.xml'
        );

        $this->arrayDocument = ['en' => 'Academic Journals R US and only us'];
    }


    // test marshalling


    /**
     * Test creating a ServiceDescription object from scratch.
     */
    public function testMarshalling(): void
    {
        $name = new ServiceDescription('en', 'Academic Journals R US and only us');

        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($name)
        );
    }


    /**
     * Test that creating a ServiceDescription from scratch with an empty language fails.
     */
    public function testMarshallingWithEmptyLang(): void
    {
        $this->expectException(AssertionFailedException::class);
        $this->expectExceptionMessage('xml:lang cannot be empty.');

        new ServiceDescription('', 'Academic Journals R US and only us');
    }


    /**
     * Test that creating a ServiceDescription from scratch with an empty value works.
     */
    public function testMarshallingWithEmptyValue(): void
    {
        $name = new ServiceDescription('en', '');

        $this->xmlRepresentation->documentElement->textContent = '';

        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($name)
        );
    }


    // test unmarshalling


    /**
     * Test creating a ServiceDescription from XML.
     */
    public function testUnmarshalling(): void
    {
        $name = ServiceDescription::fromXML($this->xmlRepresentation->documentElement);
        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($name)
        );
    }


    /**
     * Test that creating a ServiceDescription from XML fails when xml:lang is missing.
     */
    public function testUnmarshallingWithoutLang(): void
    {
        $this->xmlRepresentation->documentElement->removeAttributeNS(ServiceDescription::XML_NS, 'lang');

        $this->expectException(AssertionFailedException::class);
        $this->expectExceptionMessage('Missing xml:lang from ServiceDescription');

        ServiceDescription::fromXML($this->xmlRepresentation->documentElement);
    }


    /**
     * Test that creating a ServiceDescription from XML fails when xml:lang is empty.
     */
    public function testUnmarshallingWithEmptyLang(): void
    {
        $this->xmlRepresentation->documentElement->setAttributeNS(ServiceDescription::XML_NS, 'lang', '');

        $this->expectException(AssertionFailedException::class);
        $this->expectExceptionMessage('xml:lang cannot be empty.');

        ServiceDescription::fromXML($this->xmlRepresentation->documentElement);
    }


    /**
     * Test that creating a ServiceDescription from XML works for empty values.
     */
    public function testUnmarshallingWithEmptyValue(): void
    {
        $this->xmlRepresentation->documentElement->textContent = '';
        $name = ServiceDescription::fromXML($this->xmlRepresentation->documentElement);

        $this->assertEquals('en', $name->getLanguage());
        $this->assertEquals('', $name->getValue());
        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($name)
        );
    }
}
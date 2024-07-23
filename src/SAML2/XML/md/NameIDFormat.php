<?php

declare(strict_types=1);

namespace SimpleSAML\SAML2\XML\md;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XML\StringElementTrait;

use function trim;

/**
 * Class representing a md:NameIDFormat element.
 *
 * @package simplesaml/saml2
 */
final class NameIDFormat extends AbstractMdElement
{
    use StringElementTrait;


    /**
     * @param string $content
     */
    public function __construct(string $content)
    {
        $this->setContent($content);
    }


    /**
     * Get the content of the element.
     *
     * @return string
     */
    public function getContent(): string
    {
        return $this->sanitizeContent($this->getRawContent());
    }


    /**
     * Get the raw and unsanitized content of the element.
     *
     * @return string
     */
    public function getRawContent(): string
    {
        return $this->content;
    }


    /**
     * Sanitize the content of the element.
     *
     * @param string $content  The unsanitized textContent
     * @throws \Exception on failure
     * @return string
     */
    protected function sanitizeContent(string $content): string
    {
        // We've seen metadata in the wild that had stray whitespace around URIs, causing assertions to fail
        return trim($content);
    }


    /**
     * Validate the content of the element.
     *
     * @param string $content  The value to go in the XML textContent
     * @throws \Exception on failure
     * @return void
     */
    protected function validateContent(string $content): void
    {
        Assert::validURI($content, SchemaViolationException::class); // Covers the empty string
    }


    /**
     * Convert XML into an NameIDFormat
     *
     * @param \DOMElement $xml The XML element we should load
     * @return static
     *
     * @throws \SimpleSAML\XML\Exception\InvalidDOMElementException
     *   If the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, 'NameIDFormat', InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, NameIDFormat::NS, InvalidDOMElementException::class);

        return new static($xml->textContent);
    }
}

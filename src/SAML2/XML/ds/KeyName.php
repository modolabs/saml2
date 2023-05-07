<?php

declare(strict_types=1);

namespace SAML2\XML\ds;

use DOMElement;
use SAML2\Constants as C;
use SimpleSAML\XML\Utils as XMLUtils;

/**
 * Class representing a ds:KeyName element.
 *
 * @package SimpleSAMLphp
 */
class KeyName
{
    /**
     * The key name.
     *
     * @var string
     */
    private string $name = '';


    /**
     * Initialize a KeyName element.
     *
     * @param \DOMElement|null $xml The XML element we should load.
     */
    public function __construct(DOMElement $xml = null)
    {
        if ($xml === null) {
            return;
        }

        $this->setName($xml->textContent);
    }


    /**
     * Collect the value of the name-property
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }


    /**
     * Set the value of the name-property
     *
     * @param string $name
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }


    /**
     * Convert this KeyName element to XML.
     *
     * @param \DOMElement $parent The element we should append this KeyName element to.
     * @return \DOMElement
     */
    public function toXML(DOMElement $parent): DOMElement
    {
        return XMLUtils::addString($parent, C::NS_XDSIG, 'ds:KeyName', $this->name);
    }
}

<?php
class LessSimpleXMLElement extends SimpleXMLElement {

    /**
	 * adds a cdata node
	 *
	 * @param  string $cdata_text
	 * @return void
	 */
	public function add_cdata( $cdata_text ) {
		$node = dom_import_simplexml( $this );
		$no = $node->ownerDocument;
		$node->appendChild( $no->createCDATASection( $cdata_text ) );
	}
	/**
	 * returns a formatet xml string
	 *
	 * @return string
	 */
	public function as_formated_xml() {
		$xml_string = $this->asXML();
		$dom = new DOMDocument( '1.0', 'UTF-8' );
		$dom->loadXML( $xml_string );
		$dom->preserveWhiteSpace = FALSE;
		$dom->formatOutput = TRUE;
		return $dom->saveXML();
	}
}

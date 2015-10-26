<?php
/***************************************
PtyxisRSS
Copyright (C) 2015 Mark Kestler ptyxis.cthonic.com


GNU General Public License, version 2

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License version 2
as published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
****************************************/

class PtyxisRSS {

    protected $RSS = '';

    public function header($header)
    {
        $this->RSS = new LessSimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><rss></rss>');
        $this->RSS->addAttribute('version', '2.0');
        $channel = $this->RSS->addChild('channel');
        $channel->addChild('title', $header['title']);
        $channel->addChild('link', $header['link']);
        $channel->addChild('description', $header['description']);
        $channel->addChild('language', $header['language']);
        $channel->addChild('copyright', $header['copyright']);
        $channel->addChild('lastBuildDate', $header['lastBuildDate']);

    }

    public function add_cdata( $cdata_text ) {
		$node = dom_import_simplexml( $this );
		$no = $node->ownerDocument;
		$node->appendChild( $no->createCDATASection( $cdata_text ) );
	}

    public function addItem($item)
    {

        $result = $this->RSS->xpath('/rss/channel');
        $channel = $result[0];
        $channelItem = $channel->addChild('item');

        $title = $channelItem->addChild('title');
        $title->addCdata($item['title']);

        $channelItem->addChild('link', $item['link']);

        $description = $channelItem->addChild('description');
        $description->addCdata($item['description']);

        $channelItem->addChild('author', $item['author']);
        $channelItem->addChild('pubDate', $item['pubDate']);
        $channelItem->addChild('guid', $item['guid']);

    }

    public function getRSS()
    {
        return $this->RSS->getFormattedXml();
    }

}



class LessSimpleXMLElement extends SimpleXMLElement {

	public function addCdata( $cdata_text ) {
		$node = dom_import_simplexml( $this );
		$no = $node->ownerDocument;
		$node->appendChild( $no->createCDATASection( $cdata_text ) );
	}

	public function getFormattedXml() {
		$xmlString = $this->asXML();
		$dom = new DOMDocument( '1.0', 'UTF-8' );
		$dom->preserveWhiteSpace = FALSE;
		$dom->formatOutput = TRUE;
		$dom->loadXML( $xmlString );
		return $dom->saveXML();
	}
}

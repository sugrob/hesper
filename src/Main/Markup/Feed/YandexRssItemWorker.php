<?php
/**
 * @project    Hesper Framework
 * @author     Alex Gorbylev
 * @originally onPHP Framework
 * @originator Alexandr S. Krotov
 */
namespace Hesper\Main\Markup\Feed;

use Hesper\Core\Base\Singleton;
use Hesper\Core\Base\Timestamp;

/**
 * Class YandexRssItemWorker
 * @package Hesper\Main\Markup\Feed
 */
final class YandexRssItemWorker extends Singleton implements FeedItemWorker {

	/**
	 * @return YandexRssItemWorker
	**/
	public static function me() {
		return Singleton::getInstance(__CLASS__);
	}

	public function makeItems(\SimpleXMLElement $xmlFeed) {
		$xmlFeed->registerXPathNamespace(
			YandexRssFeedFormat::YANDEX_NAMESPACE_PREFIX,
			YandexRssFeedFormat::YANDEX_NAMESPACE_URI
		);

		$fullTextList =
			$xmlFeed->xpath(
				'//'.YandexRssFeedFormat::YANDEX_NAMESPACE_PREFIX
				.':full-text'
			);

		$result = array();

		$i = 0;

		if (isset($xmlFeed->channel->item)) {
			foreach ($xmlFeed->channel->item as $item) {
				$feedItem =
					YandexRssFeedItem::create((string) $item->title)->
					setContent(
						FeedItemContent::create()->
						setBody((string) $item->description)
					)->
					setPublished(
						Timestamp::create(
							strtotime((string) $item->pubDate)
						)
					)->
					setFullText((string) $fullTextList[$i++])->
					setLink((string) $item->link);

				if (isset($item->guid))
					$feedItem->setId($item->guid);

				if (isset($item->category))
					$feedItem->setCategory((string) $item->category);

				$result[] = $feedItem;
			}
		}

		return $result;
	}

	public function toXml(FeedItem $item) {
		return
			'<item>'
				.(
					$item->getPublished()
						?
							'<pubDate>'
								.date('r', $item->getPublished()->toStamp())
							.'</pubDate>'
						: null
				)
				.(
					$item->getId()
						?
							'<guid isPermaLink="false">'
								.$item->getId()
							.'</guid>'
						: null
				)
				.'<title>'.$item->getTitle().'</title>'
				.(
					$item->getLink()
						?
							'<link>'
							.str_replace("&", "&amp;", $item->getLink())
							.'</link>'
						: null
				)
				.(
					$item->getSummary()
						? '<description>'.$item->getSummary().'</description>'
						: null
				)
				.(
					$item->getFullText()
						? (
							'<yandex:full-text>'
							.$item->getFullText()
							.'</yandex:full-text>'
						)
						: null
				)
				.(
					$item->getCategory()
						? '<category>'.$item->getCategory().'</category>'
						: null
				)
			.'</item>';
	}
}
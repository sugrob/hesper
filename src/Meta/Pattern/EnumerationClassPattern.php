<?php
/**
 * @project    Hesper Framework
 * @author     Alex Gorbylev
 * @originally onPHP Framework
 * @originator Konstantin V. Arkhipov
 */
namespace Hesper\Meta\Pattern;

use Hesper\Meta\Builder\EnumerationClassBuilder;
use Hesper\Meta\Console\Format;
use Hesper\Meta\Entity\MetaClass;
use Hesper\Meta\Entity\MetaConfiguration;
use Hesper\Meta\Helper\NamespaceUtils;

/**
 * Class EnumerationClassPattern
 * @package Hesper\Meta\Pattern
 */
class EnumerationClassPattern extends BasePattern {

	public function daoExists() {
		return false;
	}

	public function tableExists() {
		return false;
	}

	/**
	 * @return EnumerationClassPattern
	 **/
	public function build(MetaClass $class) {
		$userFile = NamespaceUtils::getBusinessPath($class, false);

		if ( MetaConfiguration::me()->isForcedGeneration() || !file_exists($userFile) ) {
			$this->dumpFile($userFile, Format::indentize(EnumerationClassBuilder::build($class)));
		}

		return $this;
	}
}

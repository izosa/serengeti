<?

namespace izosa\serengeti\assets\lib;

use izosa\serengeti\assets\AssetBundle;


/**
 * Typeahead asset
 * @author Hristo Hristov <izosa@msn.com>
 * @since 2.0
 */
class TypeaheadAsset extends AssetBundle
{
    public $sourcePath = '@common/resources/';

    public $js = [
        'js/lib/typeahead.bundle.js',
    ];
}
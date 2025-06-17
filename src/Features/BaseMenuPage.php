<?php
declare(strict_types=1);

namespace Favit\Bootstrap\Features;

use Favit\Bootstrap\Conditionals\AdminConditional;
use Favit\Bootstrap\Integrations\Integration;

abstract class BaseMenuPage implements Integration {

    public const PAGE_SLUG = 'favit';

    public function __invoke() {
        if ( \menu_page_url( self::PAGE_SLUG, false ) !== '' ) {
            return;
        }

        \add_menu_page(
            'Favit',
            'Favit',
            'manage_options',
            self::PAGE_SLUG,
            [ 'self', 'render' ],
            'dashicons-admin-generic',
            20
        );
    }

    public function get_conditionals(): array {
        return [ AdminConditional::class ];
    }

    public function register(): void {
        \add_action( 'admin_menu', $this );
    }

    public static function render( $page_slug = self::PAGE_SLUG ) {
        echo "<div class='wrap favit-admin-wrapper'>";
        echo "<h2>Favit configuration</h2>";
        echo "<form action='options.php' method='post'>";
        \settings_fields( $page_slug );
        \do_settings_sections( $page_slug );
        \submit_button( 'Save' );

        echo "</form>";
        echo "</div>";
    }
}
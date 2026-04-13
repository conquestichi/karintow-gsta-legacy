<?php
/**
 * Karintow Child Theme functions
 *
 * SWELL を親テーマとした子テーマのベース関数ファイル。
 * CPT/ACF/カスタムテンプレートの有効化フックをここに集約する。
 *
 * @package Karintow_Child
 * @version 0.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * 子テーマのスタイルを読み込む（親SWELLのあとに）
 */
function karintow_child_enqueue_styles() {
	// 親テーマ SWELL のスタイルは SWELL 側で読み込まれるので、
	// ここでは子テーマの style.css だけをエンキューする。
	wp_enqueue_style(
		'karintow-child',
		get_stylesheet_directory_uri() . '/style.css',
		array(),
		wp_get_theme()->get( 'Version' )
	);

	// Google Fonts (Zen Kaku Gothic New + Outfit)
	wp_enqueue_style(
		'karintow-google-fonts',
		'https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&family=Zen+Kaku+Gothic+New:wght@400;500;700;900&display=swap',
		array(),
		null
	);
}
add_action( 'wp_enqueue_scripts', 'karintow_child_enqueue_styles', 20 );

/**
 * カスタム投稿タイプ `event` の登録
 *
 * 注: 本番では Custom Post Type UI プラグインでの GUI 管理を推奨する。
 * この関数はプラグインが未導入の場合のフォールバック。
 */
function karintow_register_event_cpt() {
	// Custom Post Type UI が有効ならスキップ
	if ( function_exists( 'cptui_get_post_type_slugs' ) ) {
		return;
	}

	$args = array(
		'label'               => 'イベント',
		'public'              => true,
		'has_archive'         => true,
		'rewrite'             => array( 'slug' => 'event', 'with_front' => false ),
		'supports'            => array( 'title', 'editor', 'thumbnail', 'custom-fields', 'revisions' ),
		'menu_icon'           => 'dashicons-calendar-alt',
		'show_in_rest'        => true,
	);
	// register_post_type( 'event', $args );
	// ↑ 本番運用では CPT UI 側で登録するため、ここはコメントアウトのまま
}
add_action( 'init', 'karintow_register_event_cpt' );

/**
 * 将来の拡張用: テンプレートファイル一覧
 *
 * - single-event.php       : イベント詳細ページ
 * - archive-event.php      : イベント一覧ページ
 * - taxonomy-event_category.php : カテゴリ別アーカイブ
 * - single-model.php       : モデル詳細
 * - archive-model.php      : モデル一覧
 * - front-page.php         : トップページカスタム
 *
 * これらは Phase 3 のテンプレート実装フェーズで追加する。
 */

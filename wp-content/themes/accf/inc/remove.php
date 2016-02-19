<?php
/**
 * remove bits and pieces in header
 * @author nakai kazuaki
 */
remove_action('wp_head', 'index_rel_link');                                 // linkタグを出力
remove_action('wp_head', 'rsd_link');                                       // 外部アプリケーションから情報を取得するためのプロトコル
remove_action('wp_head', 'wlwmanifest_link');                               // Windows Live Writer を使ってブログ投稿をする時に使用
remove_action('wp_head', 'start_post_rel_link', 10, 0);                     // ブラウザが先読みするためlink rel="next"などのタグを吐き出す
remove_action('wp_head', 'parent_post_rel_link', 10, 0);                   // ブラウザが先読みするためlink rel="next"などのタグを吐き出す
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);         // ブラウザが先読みするためlink rel="next"などのタグを吐き出す
remove_action('wp_head', 'feed_links_extra', 3);                            // その他のフィード（カテゴリー等）へのリンクを表示
//remove_action('wp_head', 'wp_print_styles', 8);
//remove_action('wp_head', 'wp_print_head_scripts', 9);
remove_action('wp_head', 'wp_generator');                                   // wordpressのヴァージョンを表示する
remove_action('wp_head', 'rel_canonical');                                  // URL正規化タグ ??

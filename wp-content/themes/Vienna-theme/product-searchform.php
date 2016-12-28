<div class="pm-sidebar-search-container">
    <i class="fa fa-search pm-sidebar-search-icon-btn"></i>
    <form role="search" method="get" id="searchform" action="<?php echo esc_url( home_url( '/'  ) ); ?>">
    	<input type="text" class="pm-sidebar-search-field" name="s" id="s" placeholder="<?php esc_html_e('Type keywords...', TEXT_DOMAIN) ?>" value="<?php echo get_search_query(); ?>" />
        <input type="hidden" value="product" name="post_type" id="post_type" />
    </form>
</div>

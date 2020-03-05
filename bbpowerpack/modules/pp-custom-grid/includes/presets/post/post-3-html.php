[wpbb-if post:featured_image]
<div class="pp-custom-grid-post-image">
	[wpbb post:featured_image size="large" display="tag" linked="yes"]
</div>
[/wpbb-if]

<div class="pp-custom-grid-post-text">

	<div class="pp-custom-grid-post-meta">
    	[wpbb post:date format="F j, Y"]
		<span class="pp-custom-grid-post-meta-sep"> &middot; </span>
		[wpbb post:terms_list taxonomy="category" separator=", "]
    </div>

    <h2 class="pp-custom-grid-post-title">[wpbb post:link text="title"]</h2>

    <div class="pp-custom-grid-post-excerpt">
    	[wpbb post:excerpt length="17" more="..."]
    </div>

    <div class="pp-custom-grid-post-more-link">
    	<a href="[wpbb post:url]"><span class="fa fa-angle-right"></span> Read More</a>
    </div>

</div>

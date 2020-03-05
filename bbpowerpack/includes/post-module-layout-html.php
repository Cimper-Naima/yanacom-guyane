[wpbb-if post:featured_image]
<div class="pp-content-grid-post-image">
	[wpbb post:featured_image size="large" display="tag" linked="yes"]
</div>
[/wpbb-if]

<div class="pp-content-grid-post-text">

    <h3 class="pp-content-grid-post-title">[wpbb post:link text="title"]</h3>

    <div class="pp-content-grid-post-meta">
    	[wpbb post:date format="F j, Y"]
		<span class="pp-content-grid-post-meta-sep"> | </span>
		[wpbb post:terms_list taxonomy="category" separator=", "]
    </div>

	<div class="pp-content-grid-separator"></div>

    <div class="pp-content-grid-post-excerpt">
    	[wpbb post:excerpt length="17" more="..."]
    </div>

    <div class="pp-content-grid-post-more-link">
    	<a href="[wpbb post:url]"><span class="fa fa-angle-right"></span> Read More</a>
    </div>

</div>

<div class="pp-custom-grid-post-header">
	[wpbb-if post:featured_image]
	<div class="pp-custom-grid-post-image">
		[wpbb post:featured_image size="large" display="tag" linked="yes"]
	</div>
	[/wpbb-if]
	<div class="pp-custom-grid-post-terms">
		[wpbb post:terms_list taxonomy="category" separator=", "]
	</div>
</div>

<div class="pp-custom-grid-post-text">

    <h2 class="pp-custom-grid-post-title">[wpbb post:link text="title"]</h2>

    <div class="pp-custom-grid-post-meta">
    	By [wpbb post:author_name link="yes"]
		<span class="pp-custom-grid-post-meta-sep"> / </span>
		[wpbb post:date format="F j, Y"]
    </div>

</div>

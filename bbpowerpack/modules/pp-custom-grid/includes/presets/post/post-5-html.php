[wpbb-if post:featured_image]
<div class="pp-custom-grid-post-image">
	[wpbb post:featured_image size="large" display="tag" linked="yes"]
</div>
[/wpbb-if]

<div class="pp-custom-grid-post-text">

	<h2 class="pp-custom-grid-post-title">[wpbb post:link text="title"]</h2>

	<div class="pp-custom-grid-post-meta">
		<span class="fa fa-calendar"></span>
    	[wpbb post:date format="F j, Y"]
		<span class="fa fa-user"></span>
		[wpbb post:author_name link="yes"]
	</div>

	<div class="pp-custom-grid-post-excerpt">
		[wpbb post:excerpt length="17" more="..."]
	</div>

	<div class="pp-custom-grid-post-more-link">
		<a href="[wpbb post:url]"><span class="fa fa-angle-right"></span> Read More</a>
	</div>

</div>

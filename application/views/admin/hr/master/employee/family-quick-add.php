<div class="row size-inner-section px-2 py-4">
    <h4 class="header-title">Family Information</h4><hr>
    <div id="family_sections">						
        <div class="family-inner-section">
            <div class="row">
                <div class="col-md-4 col-sm-6 col-xs-12 mb-3">
                    <div class="form-group">
                        <label class="control-label">Iqama No</label>
                        <input type="text" name="family_iqama[]" class="form-control" minlength="<?= ICAMA_LENGTH ;?>" maxlength="<?= ICAMA_LENGTH ;?>" required>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12 mb-3">
                    <div class="form-group">
                        <label class="control-label">Name</label>
                        <input type="text" name="family_name[]" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12 mb-3">
                    <div class="form-group">
                        <label class="control-label">Relationship</label>
                        <input type="text" name="family_relation[]" class="form-control" required>
                    </div>
                </div>
                <p><a href="javascript:;" class="btn btn-danger btn-sm float-end remove"><i class="fas fa-minus-square"></i> Remove</a></p>
            </div>
        </div>
    </div>

    <p><a href="javascript:;" class='btn btn-success btn-sm addsection'><i class="fas fa-plus"></i> Add More</a></p>
</div>
<script>
    //Add Family
	var template = $("#family_sections .family-inner-section:first").clone();
	//define counter
	var sectionsCount = 1;
	//add new section
	$("body").on("click", ".addsection", function () {
		//increment
		sectionsCount++;

		//loop through each input
		var section = template
			.clone()
			.find(":input").val("")
			.each(function () {
				//set id to store the updated section number
				var newId = this.id + sectionsCount;
				//alert(newId);
				$(this).prev().attr("for", newId);
				this.id = newId;
			})
			.end()
			//inject new section
			.appendTo("#family_sections");
		return false;
	});

	//remove section
	$("#family_sections").on("click", ".remove", function () {
		//fade out section
		$(this)
			.parent()
			.fadeOut(300, function () {
				//remove parent element (main section)
				$(this).parent().parent().empty();
				return false;
			});
		return false;
	});
</script>

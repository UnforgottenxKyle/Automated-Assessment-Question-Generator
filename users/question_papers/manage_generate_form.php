<?php

require_once('../../config.php');
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `question_paper_list` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
}
$single_max = $conn->query("SELECT * FROM question_list where question_paper_id = '{$id}' and `type` = 1 ")->num_rows;
$multiple_max = $conn->query("SELECT * FROM question_list where question_paper_id = '{$id}' and `type` = 2 ")->num_rows;
$text_max = $conn->query("SELECT * FROM question_list where question_paper_id = '{$id}' and `type` = 3 ")->num_rows;
$enumeration_max = $conn->query("SELECT * FROM question_list where question_paper_id = '{$id}' and `type` = 4 ")->num_rows;
$identification_max = $conn->query("SELECT * FROM question_list where question_paper_id = '{$id}' and `type` = 5 ")->num_rows;
?>
<div class="container-fluid">
	<form action="./?page=question_papers/generated_question_paper" method="POST" id="type-form">
		<input type="hidden" name ="id" value="<?php echo isset($id) ? $id : '' ?>">
		    <div class="form-group">
                <label for="single" class="control-label">No. of True or False Answer Questions to Generate</label>
                <input type="number" name="single" id="single" min= "0" max = '<?= $single_max ?>' class="form-control form-control-sm rounded-0"  required/>
                <small class="text-primary"><em><?= format_num($single_max) ?> Available Questions</em></small>
            </div>
            <div class="form-group">
                <label for="multiple" class="control-label">No. of Multiple Choice Questions to Generate</label>
                <input type="number" name="multiple" id="multiple" min= "0" max = '<?= $multiple_max ?>' class="form-control form-control-sm rounded-0"  required/>
                <small class="text-primary"><em><?= format_num($multiple_max) ?> Available Questions</em></small>
            </div>
            <div class="form-group">
                <label for="text" class="control-label">No. of Essay Answer Questions to Generate</label>
                <input type="number" name="text" id="text" min= "0" max = '<?= $text_max ?>' class="form-control form-control-sm rounded-0"  required/>
                <small class="text-primary"><em><?= format_num($text_max) ?> Available Questions</em></small>
            </div>
            <div class="form-group">
                <label for="enumeration" class="control-label">No. of Enumeration Questions to Generate</label>
                <input type="number" name="enumeration" id="enumeration" min= "0" max = '<?= $enumeration_max ?>' class="form-control form-control-sm rounded-0"  required/>
                <small class="text-primary"><em><?= format_num($enumeration_max) ?> Available Questions</em></small>
            </div>
            <div class="form-group">
                <label for="identification" class="control-label">No. of identification Questions to Generate</label>
                <input type="number" name="identification" id="identification" min= "0" max = '<?= $identification_max ?>' class="form-control form-control-sm rounded-0"  required/>
                <small class="text-primary"><em><?= format_num($identification_max) ?> Available Questions</em></small>
            </div>
        </div>
	</form>
</div>

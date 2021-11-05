@extends('layouts.app')

@section('content')

<h1>EXAM Creator</h1>

	 <input type="button" value="+" onclick="addRow()">

<div id="content">

</div>

<script>
function addRow() {
  const div = document.createElement('div');

  div.className = 'row';
  div.id = 'what theee';
  div.tagName = 'weeee';

  div.innerHTML = `
    <input type="text" name="name" value="" />
    <input type="text" name="value" value="" />
    <label> 
      <input type="checkbox" name="check" value="1" /> Checked? 
    </label>
    <input type="button" value="-" onclick="removeRow(this.parentNode.parentNode.removeChild(this.parentNode);)" />
  `;

  document.getElementById('content').appendChild(div);
}

function removeRow(sadasd) {
  document.getElementById('content').removeChild(sadasd.parentNode);
}
</script>
	<div id="question">
		<div class='input-group'>
  			<div class='input-group-prepend'>
    			<span class='input-group-text'>1</span>
  			</div>
  			<input type='text' class='form-control'  placeholder='input question or instruction'>
		</div>
		<select class='form-control' onchange='selectFunction1()' id='selectQuestion1'>
			<option>Select kind of answer</option>
			<option value='text' selected>Text Area</option>
			<option value='checkbox'>Check Box</option>
			<option value='radio'>Radio Button</option>
		</select>
		<div id='choices1' class='mb-3'>
			<div class='input-group' id='inputChoice1'></div>
			<button style='display: none' id='choiceButton1' class='btn btn-primary' onclick='addChoices()'>Add Choice</button>
		</div>

		

		<script>
			function selectFunction1(){
				var selectBox = document.getElementById('selectQuestion1');
				var selectedValue = selectBox.options[selectBox.selectedIndex].value;

				if (selectedValue == 'checkbox') {
					document.getElementById('inputChoice1').innerHTML = `<input class='form-control' type='text' id='cbChoice1' name='cbChoice1' placeholder='input choice'> `;
					document.getElementById('choiceButton1').style.display = 'block';
				}else if(selectedValue == 'radio'){
					document.getElementById('inputChoice1').innerHTML = `<input class='form-control' type='text' id='cbChoice1' name='cbChoice1' placeholder='input choice'> `;
					document.getElementById('choiceButton1').style.display = 'block';
				}
				else{
					document.getElementById('inputChoice1').innerHTML = '';
					document.getElementById('choiceButton1').style.display = 'none';

				}
			}

			function addChoices(){
				document.getElementById('inputChoice1').innerHTML += `<input class='form-control' type='text' id='cbChoice1' name='cbChoice1' placeholder='input choice'> `;
			}
		</script>

		<label>2</label>
		<input class='form-control' type='text' placeholder='input question or instruction'>
		<select class='form-control' onchange='selectFunction2()' id='selectQuestion2'>
			<option value='text' selected>Text Area</option>
			<option value='checkbox'>Check Box</option>
			<option value='radio'>Radio Button</option>
		</select>
		<div id='choices2'></div>

		<script>
			function selectFunction2(){
				var selectBox = document.getElementById('selectQuestion2');
				var selectedValue = selectBox.options[selectBox.selectedIndex].value;

				if (selectedValue == 'checkbox') {
					document.getElementById('choices2').innerHTML = `<div class='form-check'><input class='form-check-input' type='checkbox' value='' id='defaultCheck2'><label class='form-check-label' for='defaultCheck2'>Default checkbox</label></div>`
				}else if(selectedValue == 'radio'){
					document.getElementById('choices2').innerHTML = `<div class="form-check"><input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2" checked>
				  <label class="form-check-label" for="exampleRadios2">
				    Default radio
				  </label>
				</div>`;
				}
				else{
					document.getElementById('choices1').innerHTML = ``;
				}
			}
		</script>
		
	</div>
	<button class="btn btn-primary" onclick="addQuestionFunction()">Add Question </button>

<script>
var numberOfQuestion =4;

function addQuestionFunction() {
  document.getElementById("question").innerHTML += numberOfQuestion+"<input class='form-control' type='text' placeholder='input question or instruction'><select class='form-control'><option value='text' selected>Text Area</option><option value='check'>Check Box</option><option value='radio'>Radio Button</option></select><div id='choices"+numberOfQuestion+"'></div>";
  numberOfQuestion++;
}
</script>
@endsection






@extends('layouts.app')

@section('content')

<h1>EXAM Creator</h1>

<div id="questions">
	<div id="question1">
		<div class='input-group'>
			<div class='input-group-prepend'>
				<span class='input-group-text'>1</span>
			</div>
			<input type='text' class='form-control'  placeholder='input question or instruction'>
		</div>
		<div id='choices' class='mb-3'>
			<select class='form-control' onchange='selectFunction(this)' id='selectQuestion'>
				<option value='text' selected>Text Area</option>
				<option value='checkbox' onselect="">Check Box</option>
				<option value='radio'>Radio Button</option>
			</select>
			<div id='inputChoice'></div>
			</div>
			<div class="row">
				<button style='display: none' id='choiceAddButton' class='btn btn-primary' onclick='addChoices()'>Add Choice</button>
				<button style='display: none' id='choiceRemoveButton' class='btn btn-danger' onclick='removeChoices(this)'>Remove Choice</button>
		</div>
	</div>
</div>
<button class="btn btn-primary" onclick="addQuestion()">Add Question</button>
<button class="btn btn-danger" onclick="removeQuestion()">Remove Question</button>

<script>
	var numberOfQuestion =1;

	function addQuestion() {
		numberOfQuestion++
		const div = document.createElement('div');
		div.id = 'question'+numberOfQuestion;

		 div.innerHTML = `
		   <div class='input-group'>
				<div class='input-group-prepend'>
					<span class='input-group-text'>1</span>
				</div>
				<input type='text' class='form-control'  placeholder='input question or instruction'>
			</div>
			<select class='form-control' onchange='selectFunction()' id='selectQuestion'>
				<option>Select kind of answer</option>
				<option value='text' selected>Text Area</option>
				<option value='checkbox'>Check Box</option>
				<option value='radio'>Radio Button</option>
			</select>
			<div id='choices' class='mb-3'>
				<div id='inputChoice'></div>
				<div class="row">
					<button style='display: none' id='choiceAddButton' class='btn btn-primary' onclick='addChoices()'>Add Choice</button>
					<button style='display: none' id='choiceRemoveButton' class='btn btn-danger' onclick='removeChoices(this)'>Remove Choice</button>
				</div>
			</div>
		  `;
		  document.getElementById('questions').appendChild(div);
	}
	function removeQuestion(){
		var questions = document.getElementById('questions');
		questions.removeChild(questions.lastChild);
		numberOfQuestion--;
	}


	function selectFunction(input){
		var selectBox = document.getElementById('selectQuestion');
		var selectedValue = selectBox.options[selectBox.selectedIndex].value;
		const choice = document.createElement('input');
		choice.className = 'form-control';
		choice.type = 'text';
		choice.placeholder= 'input choice';

		if (selectedValue == 'checkbox') {
			document.getElementById('inputChoice').appendChild(choice);
			document.getElementById('choiceAddButton').style.display = 'block';
			document.getElementById('choiceRemoveButton').style.display = 'block';

		}else if(selectedValue == 'radio'){
			document.getElementById('inputChoice').appendChild(choice);
			document.getElementById('choiceAddButton').style.display = 'block';
			document.getElementById('choiceRemoveButton').style.display = 'block';
		}
		else{
			document.getElementById('inputChoice').innerHTML = '';
			document.getElementById('choiceAddButton').style.display = 'none';
			document.getElementById('choiceRemoveButton').style.display = 'none';
		}
	}

	function addChoices(){
		const choice = document.createElement('input');
		choice.className = 'form-control';
		choice.type = 'text';
		choice.placeholder= 'input choice';
		document.getElementById('inputChoice').appendChild(choice);
	}
	function removeChoices(input){
		var inputChoice = document.getElementById('inputChoice');
		inputChoice.removeChild(inputChoice.lastChild);
	}
</script>
@endsection
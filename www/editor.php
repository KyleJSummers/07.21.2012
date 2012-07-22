<?php

	$css_styles = <<<EOL
<style>  
      .ace-editor {
				position: absolute;
				width: 650px;
				height: 450px;
				border: 1px solid #DDD;
      }
      
      #editor-container {
	      height: 550px;
      }
      
      #editor-container ul {
	      margin-bottom: 5px;
      }
      
      #edit-region {
	      width: 660px;
      }
      
      #file-tree {
	      overflow: auto;
	      height: 450px;
      }
      
      i.icon-remove {
	      visibility: hidden;
      }
      
      ul.nav-tabs li.active i.icon-remove {
      	visibility: visible;
      }
      
      .icon-remove:hover {
	      background-color: #ccc;
	      border-radius: 2px;
      }
      
      #user-pointer {
	      position: absolute;
	      top: -400px;
	      left: -400px;
	      z-index: 10000;
      }
    </style>
    <link href="css/chosen.css" rel="stylesheet">
    <link href="css/jqueryFileTree.css" rel="stylesheet" />
EOL;

	include 'inc/header.php';
?>
	    <div class="row">

		    <div class="span2" id="file-tree-div">
		    	<h2>Files</h2>
			    <div id="file-tree"></div>
		    </div>
		    <div class="span7" id="edit-region">

			    <div class="tabbable" id="editor-container">
			    	<ul class="nav nav-tabs">
				    	<li class="active"><a href="#editor-1" data-toggle="tab">proj1.cpp <i class="icon-remove"></i></a></li>
				    	<li><a href="#editor-2" data-toggle="tab">stack.h <i class="icon-remove"></i></a></li>
				    	<li><a href="#editor-3" data-toggle="tab">stack.cpp <i class="icon-remove"></i></a></li>
				    </ul>
				    <div class="tab-content">
					    <div class="tab-pane active" id="editor-1">
						    <div class="ace-editor" id="ace-edit-1">#include &lt;iostream&gt;
#include "stack.h1"

using namespace std;

int main ()
{
	cout << "Hello World!" << endl;
}</div>
						  </div>
						  <div class="tab-pane" id="editor-2">
							  <div class="ace-editor" id="ace-edit-2">#include &lt;iostream&gt;
#include "stack.h1"

using namespace std;

int main ()
{
	cout << "Hello World!" << endl;
}</div>
							</div>
							<div class="tab-pane" id="editor-3">
							  <div class="ace-editor" id="ace-edit-3">// stack.cpp</div>
							</div>
						</div>
					</div>
			
		    </div>
		    
		    <div class="span3">
		    	<h2>Chat</h2>
		    </div>
		
	  </div>
		
		<i class="icon-pencil" id="user-pointer"></i>	

<?php

	$js_scripts = '<script>var username = "' . $user . '";</script>';
	$js_scripts .= '<script>var to_user = "' . htmlspecialchars($_GET['p']) . '";</script>';
	
	if($_GET['i'] == 1) {
		$js_scripts .= '<script>var role = 1;</script>';
	}
	else {
		$js_scripts .= '<script>var role = 0;</script>';
	}
	
	$js_scripts .= <<<EOL
    <script src="js/bootstrap-tab.js"></script>
    <script src="js/ace/ace.js"></script>
    <script src="js/ace/theme-textmate.js"></script>
    <script src="js/ace/mode-c_cpp.js"></script>
    <script src="js/jqueryFileTree.js"></script>
    <script src="http://kjsum.com:8080/socket.io/socket.io.js"></script>
    
    <script>
    	function initEditor(id) {
	    	var editor = ace.edit(id);
	    	editor.setTheme("ace/theme/textmate");
	    	var CppMode = require("ace/mode/c_cpp").Mode;
	    	editor.getSession().setMode(new CppMode());
	    	
	    	return editor;
    	}
    	
    	var edit1;
    	var edit2;
    	
    	var socket = io.connect('http://kjsum.com:8080');
    	
    	socket.on('update', function (msg) {
  			//console.log(msg.delta.data);
  			change = [msg.delta.data];
  			edit1.getSession().doc.applyDeltas(change);
    		edit1.renderer.updateFull();
	    });
	    
	    socket.on('cursor', function (cursor) {
	    	//console.log("Cursor");
	    	var range = cursor.selection;
	    	var cursor = cursor.cursor;
	    	//console.log(cursor);
		    edit1.gotoLine(cursor.row+1, cursor.column);
		    //console.log("Selection...");
		    //console.log(range);
		    if (range != null) {
			    edit1.getSession().selection.setSelectionRange(range);
		    }
		    else {
		    	console.log("Clearing selection");
			    edit1.getSession().selection.clearSelection();
		    }
	    });
	    
	    socket.on('mousemove', function (mouse) {
	    	console.log(mouse);
	    	$("#user-pointer").css('left', mouse.position.position.x + $('#editor-container').position().left);
	    	$("#user-pointer").css('top', mouse.position.position.y + $('#editor-container').position().top);
	    });
	    
	    var mouse_count = 0;
    	
    	$(function() {
    	
	    	edit1 = initEditor("ace-edit-1");
	    	//console.log(edit1);
	    	edit2 = initEditor("ace-edit-2");
	    	var edit3 = initEditor("ace-edit-3");
	    	
	    	var users;
				socket.on('hello', function (data) {
					console.log(data.hello);
					socket.emit('rename', {from: data.hello, to: username});
				});
				socket.on('listing', function (data) {
					users = data;
				});
	    	
	    	$("#editor-container").mousemove( function(e){
	    		mouse_count++;
	    		if (role == 0 && mouse_count % 2 == 0) {
	    			mouse_count = 1;
			      var mouse = {};
			      mouse.x = e.pageX - $('#editor-container').position().left;
			      mouse.y = e.pageY - $('#editor-container').position().top;
			      socket.emit('mousemove', { user: to_user, position: mouse });
		      }
	      });
	    	
	    	edit1.getSession().on("change", function (e) {
	    		if (role == 0) {
		    		socket.emit('change', { user: to_user, delta: e });
	    		}
        });
        
        edit1.getSession().selection.on("changeCursor", function () {
        	if (role == 0) {
	          var cursor = edit1.getCursorPosition();
	          
	          var range = null;
	          
	          if ( !edit1.getSession().selection.isEmpty() ) {
		          range = edit1.getSession().selection.getRange();
	          }
	          
	          //console.log("Selection...");
	          //console.log(range);
	          
	          socket.emit('cursor', { user: to_user, cursor: cursor, selection: range });
          }
        });
	    	
	    	$('#file-tree').fileTree({
	    			root: '/some/folder/',
	    			script: 'file-tree.html',
	    			expandSpeed: -1,
	    			collapseSpeed: -1,
	    		}, function(file) {
        	alert(file);
        });
    	});
    </script>
EOL;

include 'inc/footer.php';

?>

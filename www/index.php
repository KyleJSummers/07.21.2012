<?php

// index.php
// Hacker Helpline homepage

include 'inc/header.php';

?>

<div class="row">
        <div class="span6">
          <h2>Current Users</h2>
           	<form class="well form-inline" method="post" action="select-univ.php">
	          	<label class="control-label" for="university">University:</label>	
							<select name="univ" data-placeholder="Select your university" class="chzn-select" style="width: 300px">
								<option value=""></option>
								<option>California Institute of Technology (Caltech)</option>
								<option>Carnegie Mellon University (CMU)</option>
								<option>Cornell University</option>
								<option>Georgia Institute of Technology (Georgia Tech)</option>
								<option>Massachusetts Institute of Technology (MIT)</option>
								<option>Stanford University</option>
								<option>University of California - Berkeley</option>
								<option>University of Illinois - Urbana-Champaign (UIUC)</option>
								<option value="umich">University of Michigan - Ann Arbor</option>
							</select>
				
						<button class="btn" type="submit">Go</button>
					</form>
        </div>
        <div class="span6">
          <h2>Get Started</h2>
          <p>Don't have a Hacker Helpline account with your university? Get started today.</p>
          <p><a class="btn" href="#">Let's Go &raquo;</a></p>
        </div>
      </div>

      <!-- Main hero unit for a primary marketing message or call to action -->
      <div class="hero-unit">
        <h1>Welcome to Hacker Helpline</h1>
        <p>Hacker Helpline facilities online office hours for university programming courses.</p>
        
        <p><em>Students:</em> Get help with your code live with your instructor where and when convenient, in a beautiful, browser-based code editor while you video chat face to face. Use whatever editor you wish &mdash; your code syncs directly with our app.</p>
        
        <p><em>Instructors:</em> Help your students remotely. Streamline your programming office hours.</p>
        <p><a class="btn btn-primary btn-large">Learn more &raquo;</a></p>
      </div>

<?php

include 'inc/footer.php';

?>
<main class="content">
	<div class="container-fluid p-0">

		<h1 class="h3 mb-3"><strong>File Storage</strong></h1>

		<div class="row">
			<div class="col-12 d-flex">
				<div class="card flex-fill">
					<div class="card-header d-flex justify-content-end">
						<a data-bs-toggle="modal" data-bs-target="#addFile"><i class="align-middle me-2" data-feather="plus"></i></a>
					</div>
					<table class="table table-hover my-0">
						<thead>
							<tr>
								<th>File Name</th>
								<th>Date Added</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$files = "SELECT * FROM files";
								$getFiles = mysqli_query($db, $files);
								while ($file = mysqli_fetch_assoc($getFiles)) {
									$name = $file['file_name'];
									echo '<td>' . $name . '</td>';
									echo '<td>' . $file['uploaded_on'] . '</td>';
									echo '
											<td>
												<a href="uploads/'.$name.' " download>
													<i class="align-middle" data-feather="download"></i>
												</a>
												<a href="">
													<i class="align-middle me-2" data-feather="trash-2"></i>
												</a>
											</td>';
								}
								//echo readfile("uploads/dpworld.png");
							?>
						</tbody>
					</table>
				</div>
			</div>			
		</div>
	</div>
</main>
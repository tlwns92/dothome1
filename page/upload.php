<div id="wrapper">
    <div id="page">
        <div id="content">
            <div id="actions" class="row">
                <div class="col-lg-7">
                <span class="btn btn-success fileinput-button dz-clickable">
                    <i class="glyphicon glyphicon-plus"></i>
                    <span>Download</span>
                </span>
                <button type="submit" class="btn btn-primary start" onclick="uploadFiles()">
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Start upload</span>
                </button>
                <button type="reset" class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel upload</span>
                </button>
                </div>
            </div>
            <div id="dropzone">
                <form action="upload_check.php" class="dropzone needsclick" id="demo-upload" 
                acceptedFiles="image/jpeg,image/png,application/dicom">
                <div class="dz-message needsclick">
                    <span class="text">
                    <img src="http://www.freeiconspng.com/uploads/------------------------------iconpngm--22.png" alt="Camera" />
                    Drop files here or click to upload.
                    </span>
                    <span class="plus">+</span>
                </div>
                </form>
            </div>
        </div>
    
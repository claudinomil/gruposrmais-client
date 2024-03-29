<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18" id="currentPageTitle">{{ \App\Facades\Breadcrumb::getCurrentPageTitle() }}<span></span></h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route(\App\Facades\Breadcrumb::getPreviousPageRoute()) }}">{{ \App\Facades\Breadcrumb::getPreviousPageTitle() }}</a></li>
                    <li class="breadcrumb-item active">{{ \App\Facades\Breadcrumb::getCurrentPageTitle() }}</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->

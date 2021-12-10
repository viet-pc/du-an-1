@extends('layouts.admin')
@section('main')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <h3 class="card-header">Thêm bài viết mới</h3>
                <div class="card-body">
                    <form id="pulseForm">
                        <div class="form-group">
                          <label for="exampleFormControlInput1">Tiêu đề bài viết (*)</label>
                          <input type="text" class="form-control" id="title" placeholder="Nhập tiêu đề của bài viết">
                        </div>
                        <div class="form-group">
                          <label for="category">Chọn danh mục (*)</label>
                          <select class="form-control" id="category">
                              @foreach($category as $item)
                                <option value="{{$item->Blog_CategoryID}}">{{$item->BlogName}}</option>
                              @endforeach
                          </select>
                        </div>
                        <div class="form-group">
                            <label for="desc">Mô tả (*)</label>
                            <textarea id="desc" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                          <label for="editor">Nội dung (*)</label>
                          <textarea id="editor" class="form-control" rows="3"></textarea>
                        </div>
                            <label for="thumbnail" class="col-sm-2 col-form-label">Thumbnail (*)</label>
                            <div class="dropzone" id="thumbnail" type="file"></div>
                        </div>
                        <div class="form-group p-4">
                            <button id="post" type="button" class="btn-outline-primary waves-effect waves-light">Đăng bài</button>
                            <a style="color: #fff" id="preview" type="button" class="btn btn-outline waves-effect waves-light">Xem bài viết</a>
                            <a style="color: #fff" id="addNewPost" href="{{url('admin/blog/new')}}" type="button" class="btn btn-primary waves-effect waves-light">Thêm bài mới</a>
                        </div>
                      </form>
                </div>
            </div>
        </div>
    </div>
@stop()
@section('scripts')
<script type="text/javascript">
var thumbnail;

$('#preview').hide();
$('#addNewPost').hide();

class MyUploadAdapter {
    constructor( loader ) {
        // The file loader instance to use during the upload. It sounds scary but do not
        // worry — the loader will be passed into the adapter later on in this guide.
        this.loader = loader;
    }

    // Starts the upload process.
    upload() {
        return this.loader.file
            .then( file => new Promise( ( resolve, reject ) => {
                this._initRequest();
                this._initListeners( resolve, reject, file );
                this._sendRequest( file );
            } ) );
    }

    // Aborts the upload process.
    abort() {
        if ( this.xhr ) {
            this.xhr.abort();
        }
    }

    _initRequest() {
        const xhr = this.xhr = new XMLHttpRequest();

        // Note that your request may look different. It is up to you and your editor
        // integration to choose the right communication channel. This example uses
        // a POST request with JSON as a data structure but your configuration
        // could be different.
        xhr.open( 'POST', "{{url('/api/upload/image')}}", true );
        xhr.setRequestHeader( 'x-csrf-token', '{{csrf_token()}}')
        xhr.responseType = 'json';
    }


    _initListeners( resolve, reject, file ) {
        const xhr = this.xhr;
        const loader = this.loader;
        const genericErrorText = `Couldn't upload file: ${ file.name }.`;

        xhr.addEventListener( 'error', () => reject( genericErrorText ) );
        xhr.addEventListener( 'abort', () => reject() );
        xhr.addEventListener( 'load', () => {
            const response = xhr.response;

            // This example assumes the XHR server's "response" object will come with
            // an "error" which has its own "message" that can be passed to reject()
            // in the upload promise.
            //
            // Your integration may handle upload errors in a different way so make sure
            // it is done properly. The reject() function must be called when the upload fails.
            if ( !response || response.error ) {
                return reject( response && response.error ? response.error.message : genericErrorText );
            }

            // If the upload is successful, resolve the upload promise with an object containing
            // at least the "default" URL, pointing to the image on the server.
            // This URL will be used to display the image in the content. Learn more in the
            // UploadAdapter#upload documentation.
            resolve( {
                default: response.url
            } );
        } );

        // Upload progress when it is supported. The file loader has the #uploadTotal and #uploaded
        // properties which are used e.g. to display the upload progress bar in the editor
        // user interface.
        if ( xhr.upload ) {
            xhr.upload.addEventListener( 'progress', evt => {
                if ( evt.lengthComputable ) {
                    loader.uploadTotal = evt.total;
                    loader.uploaded = evt.loaded;
                }
            } );
        }
    }

    _sendRequest( file ) {
        // Prepare the form data.
        const data = new FormData();

        data.append( 'upload', file );

        // Important note: This is the right place to implement security mechanisms
        // like authentication and CSRF protection. For instance, you can use
        // XMLHttpRequest.setRequestHeader() to set the request headers containing
        // the CSRF token generated earlier by your application.

        // Send the request.
        this.xhr.send( data );
    }
}

function UploadAdapterPlugin( editor ) {
    editor.plugins.get( 'FileRepository' ).createUploadAdapter = ( loader ) => {
        // Configure the URL to the upload script in your back-end here!
        return new MyUploadAdapter( loader );
    };
}
var myEditor;
    ClassicEditor
        .create( document.querySelector( '#editor' ), {
            extraPlugins: [ UploadAdapterPlugin ],

        })
        .then( editor => {
            myEditor = editor;
            editor.ui.view.editable.element.style.height = '500px';
        } )
        .catch( error => {
            console.error( error );
        } );
</script>


<script>

new Dropzone("#thumbnail", {
    url: "/api/upload/image",
    paramName: 'upload',
    maxFilesize: 2, // MB
    maxFiles: 1,
    addRemoveLinks: true,
    dictDefaultMessage: "Kéo ảnh của bạn vào đây để tải lên",
    dictMaxFilesExceeded: "Bạn chỉ có thể tải lên 1 ảnh",
    dictRemoveFile: "Xoá",
    dictCancelUploadConfirmation: "Bạn muốn huỷ tải lên?",
    headers: {
        'x-csrf-token': '{{csrf_token()}}'
    },
    init: function () {
        this.on("success", function (file, responseText) {
        console.log(responseText);
        thumbnail = responseText.fileName;
        console.log(thumbnail);
      });
    }
});
</script>

<script>
    $(document).ready(function() {
        $('#post').click(function(e) {
            Notiflix.Block.Pulse('#pulseForm');
            e.preventDefault();
            $.ajax({
                url: "{{url('api/post/new-post')}}",
                type: 'POST',
                data: {
                    content: myEditor.getData(),
                    thumbnail: thumbnail,
                    title: $('#title').val(),
                    description: $('#desc').val(),
                    categoryId: $('#category').find(":selected").val(),
                    _token: "{{csrf_token()}}"
                }
            }).done(function(res) {
                Notiflix.Block.Remove('#pulseForm');
                if(res.success == true){
                    Notiflix.Notify.Success(res.messages);
                    $('#preview').attr('href',res.redirect);
                    $('#preview').show();
                    $('#addNewPost').show();
                    $('#post').hide();
                }else{
                    Notiflix.Notify.Warning(res.messages);
                }
            });
        });
    })

</script>
@stop()

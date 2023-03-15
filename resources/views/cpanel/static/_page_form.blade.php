<form class="static-page-form" method="POST" action="{{ empty($page) ? route('page.add') : route('page.edit', ['page' => $page->id]) }}" id="static-form">
    @csrf
    @if(!empty($page))
        @method('PUT')
    @endif

    @if (!empty($parent_id))
        <input type="hidden" name="parent_id" value="{{ $parent_id }}">
    @endif

    @if (!empty($position))
        <input type="hidden" name="position" value="{{ $position }}">
    @endif

    @if (!empty($currLang))
        <input type="hidden" name="language_id" value="{{ $currLang->id }}">
    @endif

    @include('pages.widgets._alert_both_success_error', [])

    <div class="form-group row">
        <label class="col-2 col-form-label" for="name" class="required">{{ __('Page name')}} <i class="text-danger">*</i></label>
        <div class="col-10">
            <input type="text" class="form-control" name="name" value="{{old('name', $local->name ?? '')}}" id="name" placeholder="Menu name"/>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-2 col-form-label" for="header" class="required">{{ __('Page header') }} <i class="text-danger">*</i></label>
        <div class="col-10">
            <input type="text" class="form-control" name="header" value="{{old('header', $local->header ?? '')}}" id="header" placeholder="H1 header"/>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-2 col-form-label" for="text">{{  __('Text') }} <i class="text-danger">*</i></label>
        <div class="col-10">
            <textarea id="textTineMCE" class="text-tine-MCE" name="text">{{old('text', $local->text ?? '')}}</textarea>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-2 col-form-label" for="slug">{{ __('Page URL') }}</label>
        <div class="col-10">
            <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text">@</span></div>
                <input type="text" class="form-control" name="slug" value="{{old('slug', $page->slug ?? '')}}" id="slug" placeholder="Slug / Page URL"/>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-2 col-form-label" for="type">Type</label>
        <div class="col-10">
            <select class="form-control" name="type" id="type">
                @foreach($staticPageTypes::list() as $option => $optionName)
                    <option {{ old('type', $page->type ?? __('Choose page type')) === $option ? 'selected' : '' }} value="{{ $option }}">{{ $optionName }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-2 col-form-label"></label>
        <div class="col-10 col-form-label">
            <div class="checkbox-list">
                <label class="checkbox">
                    <input type="checkbox" name="display" id="display" value="1" {{ old('display', $page->display ?? true) ? 'checked' : '' }}/>
                    <span></span>
                    @lang('Show in menu')
                </label>
            </div>
        </div>
    </div>

    <div class="separator separator-dashed my-8"></div>

    <div class="form-group row">
        <label class="col-2 col-form-label" for="title">{{ __('Title') }}</label>
        <div class="col-10">
            <input type="text" class="form-control" name="title" value="{{old('title', $local->title ?? '')}}" id="title" placeholder="META Title"/>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-2 col-form-label" for="keywords">{{ __('Keywords') }}</label>
        <div class="col-10">
            <input type="text" class="form-control" name="keywords" value="{{old('keywords', $local->keywords ?? '')}}" id="keywords" placeholder="META Keywords"/>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-2 col-form-label" for="text">{{ __('Description') }}</label>
        <div class="col-10">
            <textarea class="form-control" name="description" id="text">{{old('description', $local->description ?? '')}}</textarea>
        </div>
    </div>

    <div class="card-footer">
        <button type="submit" class="btn width-200 btn-primary">{{ __('Update') }}</button>
        @if(!empty($page))
            <button type="reset" class="btn btn-default">{{ __('Cancel') }}</button>
        @endif
    </div>
</form>
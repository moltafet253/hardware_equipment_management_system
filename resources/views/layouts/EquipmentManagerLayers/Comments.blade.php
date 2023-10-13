<form id="new-comment">
    @csrf
    <div class="mb-4 flex items-center">
{{--        <div class="fixed z-10 inset-0 overflow-y-auto " id="addCommentModal">--}}
                    <div class="fixed z-10 inset-0 overflow-y-auto hidden" id="addCommentModal">
            <div
                class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center  sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75 addcomment"></div>
                </div>
                <div
                    class="inline-block align-bottom bg-white rounded-lg text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full sm:max-w-[550px]">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                            ثبت کار جدید
                        </h3>
                        <div class="mt-4">
                            <div class="flex w-full">
                                <div class="ml-4">
                                    <label for="property_id"
                                           class="block text-gray-700 text-sm font-bold mb-2">شماره اموال*</label>
                                    <input type="text" id="property_id" name="property_id"
                                           class="border rounded-md w-full mb-4 px-3 py-2 text-right "
                                           placeholder="شماره اموال را وارد کنید">
                                </div>
                                <div>
                                    <label for="title"
                                           class="block text-gray-700 text-sm font-bold mb-2">نوع دستگاه</label>
                                    <input type="text" id="property_id" name="property_id" value="{{ $product }}"
                                           class="border rounded-md w-full mb-4 px-3 py-2 text-right bg-gray-200"
                                           disabled
                                           placeholder="شماره اموال را وارد کنید">
                                </div>
                            </div>
                            <div class="">
                                <div class="ml-3 w-full">
                                    <label for="title"
                                           class="block text-gray-700 text-sm font-bold mb-2">موضوع*</label>
                                    <input type="text" id="title" name="title"
                                           class="border rounded-md w-full mb-4 px-3 py-2 text-right "
                                           placeholder="موضوع را وارد کنید">
                                </div>
                            </div>
                            <div class="">
                                <div class="ml-3 w-full">
                                    <label for="ticket_number"
                                           class="block text-gray-700 text-sm font-bold mb-2">شماره تیکت</label>
                                    <input type="text" id="ticket_number" name="ticket_number"
                                           class="border rounded-md w-full mb-4 px-3 py-2 text-right "
                                           placeholder="شماره تیکت را وارد کنید">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="jobs"
                                       class="block text-gray-700 text-sm font-bold mb-2">کارها</label>
                                <select id="jobs[]" class="border rounded-md w-full px-3 py-2 h-72" name="jobs[]"
                                        multiple>
                                    @php
                                        $jobs = \App\Models\Catalogs\Job::orderBy('title')->get();
                                    @endphp
                                    @foreach($jobs as $job)
                                        <option value="{{ $job->id }}">
                                            {{ $job->title  }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="description"
                                       class="block text-gray-700 text-sm font-bold mb-2">توضیحات*</label>
                                <textarea id="description" name="description"
                                          class="border rounded-md w-full px-3 py-2"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit"
                                class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                            ثبت کار
                        </button>
                        <button id="cancel-add-comment" type="button"
                                class="mt-3 w-full inline-flex justify-center px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring focus:border-blue-300 sm:mt-0 sm:w-auto">
                            انصراف
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>


<div class="flex pb-3 ">
    <button type="submit"
            class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300 AddComment">
        ثبت کار جدید
    </button>
</div>

@if( isset($comments) )
    <div class="bg-white rounded shadow flex flex-col">
        <div class="max-w-full items-center overflow-x-auto">
            <table class="w-full border-collapse rounded-lg overflow-hidden text-center">
                <thead>
                <tr class="bg-gradient-to-r from-blue-400 to-purple-500 items-center text-center text-white">
                    <th class=" px-6 py-3  font-bold ">موضوع</th>
                    <th class=" px-6 py-3  font-bold ">شماره تیکت</th>
                    <th class=" px-3 py-3  font-bold ">کارها</th>
                    <th class=" px-3 py-3  font-bold ">توضیحات</th>
                    <th class=" px-3 py-3  font-bold ">عملیات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($comments as $comment)
                    <tr class="even:bg-gray-300 odd:bg-white">
                        <td class=" px-3 py-3 "> {{ $comment->title }}</td>
                        <td class=" px-3 py-3 "> {{ $comment->ticket_number }}</td>
                        <td class=" px-3 py-3 ">
                            @if($comment->jobs)
                                @foreach (json_decode($comment->jobs) as $job)
                                    @php
                                        $jobInfo=\App\Models\Catalogs\Job::find($job);
                                    @endphp
                                    {{ $jobInfo->title }}
                                    @unless ($loop->last)
                                        |
                                    @endunless
                                @endforeach
                            @endif
                        </td>
                        <td class=" px-3 py-3 ">
                            {{ $comment->description }}
                        </td>
                        <td class=" px-3 py-3 ">
                            <button type="submit"
                                    class="px-4 py-2 mr-3 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300 EditComment">
                                ویرایش
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="flex p-3">
                <h3 @if(!$comments->isEmpty()) hidden="hidden"
                    @endif class="font-bold text-red-500 ml-4 mt-2" id="CommentErr">برای این
                    پرسنل، کار ثبت
                    نشده است.</h3>
            </div>
        </div>
    </div>

@endif

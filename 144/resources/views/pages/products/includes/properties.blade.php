<h2 class="uppercase text-gray-500 font-semibold my-4 text-center md:text-left">
    <i class="fal fa-memo"></i> @lang('pages/products.properties')</h2>

    <table class="table-fixed divide divide-neutral-200 w-full bg-white shadow-2xl rounded-md">
        @foreach($product->getProductAttributes()->get() as $attribute)

            <tr class="even:bg-sky-100">

                <td class="py-2 px-6 2xl:flex">
                    <span class="font-semibold">{{ $attribute->getName() }}:</span>
                    <span class="2xl:text-right grow block">{{ $attribute->getValue() }}</span>
                </td>

            </tr>

        @endforeach
    </table>


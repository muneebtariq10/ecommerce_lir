import AdminAuthenticated from "@/Layouts/AdminAuthenticatedLayout";
import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import TextInput from "@/Components/TextInput";
import { Head, Link, useForm } from "@inertiajs/react";
import SelectInput from "@/Components/SelectInput";
import TextAreaInput from "@/Components/TextAreaInput";

export default function Create({auth, category, parents}) {
    const { data, setData, post, errors, reset } = useForm({
        name: category.name || '',
        sort: category.sort || '',
        image: '',
        banner: '',
        status: category.status || '',
        parent_id: category.parent_id || '',
        short_url: category.short_url || '',
        description: category.description || '',
        _method: 'PUT'
    })

    const onSubmit = (e) => {
        e.preventDefault()

        post(route('category.update', category.id))
    }

    return (
        <AdminAuthenticated
            user={auth.user}
            header={
                <div className="flex justify-between items-center">
                    <h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Edit Category "{category.name}"</h2>
                </div>
            }
        >
            <Head title="Categories" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <form onSubmit={onSubmit} className="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                            {category.banner && (
                                <div className="">
                                    <img src={category.banner} className="w-full h-40" />
                                </div>
                            )}
                            {category.image && (
                                <div className="flex justify-center items-center mb-4">
                                    <img src={category.image} className="w-64" />
                                </div>
                            )}
        
                            <div className="mt-0">
                                <InputLabel htmlFor="category_name" value="Name" />
                                <TextInput
                                    id="category_name" 
                                    type="text" 
                                    name="name"
                                    value={data.name}
                                    isFocused={true}
                                    className="mt-1 block w-full"
                                    onChange={e => setData('name', e.target.value)}
                                />
                                <InputError message={errors.name} className="mt-2" />
                            </div>

                            <div className="mt-4">
                                <InputLabel htmlFor="category_image" value="Image" />
                                <TextInput
                                    id="category_image" 
                                    type="file" 
                                    name="image"
                                    className="mt-1 block w-full"
                                    onChange={e => setData('image', e.target.files[0])}
                                />
                                <InputError message={errors.image} className="mt-2" />
                            </div>

                            <div className="mt-4">
                                <InputLabel htmlFor="category_banner" value="Banner" />
                                <TextInput
                                    id="category_banner" 
                                    type="file" 
                                    name="banner"
                                    className="mt-1 block w-full"
                                    onChange={e => setData('banner', e.target.files[0])}
                                />
                                <InputError message={errors.banner} className="mt-2" />
                            </div>
                            
                            <div className="mt-4">
                                <InputLabel htmlFor="category_parent" value="Parent" />

                                <SelectInput
                                    name="parent_id"
                                    id="category_parent"
                                    className="mt-1 block w-full"
                                    defaultValue={data.parent_id}
                                    onChange={(e) => setData("parent_id", e.target.value)}
                                >
                                    <option value="0">Select Parent Category</option>
                                    {parents.data.map(parent => (
                                        <option value={parent.id} key={parent.id}>{parent.name}</option>
                                    ))}
                                </SelectInput>

                                <InputError message={errors.parent_id} className="mt-2" />
                            </div>
                            
                            <div className="mt-4">
                                <InputLabel htmlFor="category_status" value="Status" />

                                <SelectInput
                                    name="status"
                                    id="category_status"
                                    defaultValue={data.status}
                                    className="mt-1 block w-full"
                                    onChange={(e) => setData("status", e.target.value)}
                                >
                                    <option value="">Select Status</option>
                                    <option value="disabled">Disabled</option>
                                    <option value="enabled">Enabled</option>
                                </SelectInput>

                                <InputError message={errors.status} className="mt-2" />
                            </div>
                            
                            <div className="mt-4">
                                <InputLabel htmlFor="category_url" value="Short URL" />
                                <TextInput
                                    id="category_url" 
                                    type="text" 
                                    name="short_url"
                                    value={data.short_url}
                                    className="mt-1 block w-full"
                                    onChange={e => setData('short_url', e.target.value)}
                                />
                                <InputError message={errors.short_url} className="mt-2" />
                            </div>

                            <div className="mt-4">
                                <InputLabel
                                    htmlFor="category_description"
                                    value="Category Description"
                                />

                                <TextAreaInput
                                    id="category_description"
                                    name="description"
                                    value={data.description}
                                    className="mt-1 block w-full"
                                    onChange={(e) => setData("description", e.target.value)}
                                />

                                <InputError message={errors.description} className="mt-2" />
                            </div>

                            <div className="mt-4 text-right">
                                <Link
                                    href={route("category.index")}
                                    className="bg-gray-100 py-1 px-3 text-gray-800 rounded shadow transition-all hover:bg-gray-200 mr-2"
                                >
                                    Cancel
                                </Link>
                                <button className="bg-emerald-500 py-1 px-3 text-white rounded shadow transition-all hover:bg-emerald-600">
                                    Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </AdminAuthenticated>
    )
}
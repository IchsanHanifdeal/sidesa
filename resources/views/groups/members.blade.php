<x-app-layout>
    <div class="w-full min-h-screen mx-auto px-3">
        <div class="overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-2xl font-bold mb-4">Group Members ({{ $members->count() }} Orang)</h2>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($members as $member)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                @if ($member->image)
                                                    <img class="h-10 w-10 rounded-full"
                                                        src="{{ asset('storage/images/' . $member->image) }}"
                                                        alt="Group Image">
                                                @else
                                                    <img class="h-10 w-10 rounded-full"
                                                        src="https://ui-avatars.com/api/?name={{ $member->name }}&color=7F9CF5&background=EBF4FF"
                                                        alt="User Image">
                                                @endif
                                            </div>
                                            <div class="ml-4 text-sm font-medium text-gray-900">{{ $member->name }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($isAdminGroup)
                                            <form action="{{ route('groups.members.delete', ['id' => $group->id, 'memberId' => $member->id]) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                    Delete
                                                </button>
                                            </form>
                                        @endif

                                        @if ($member->status == 'Pending' && $isAdminGroup)
                                            <form action="{{ route('groups.members.confirm', ['id' => $group->id, 'memberId' => $member->id]) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="inline-flex mt-2 items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                    Konfirmasi
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-guest-layout>

    <div class="font-weight-bolder text-xl">Requested Invitation</div>

    <ul class="my-4 py-4">
        <li class="listItem">Name: {{ $invitation->name }}</li>
        <li class="listItem">Email: {{ $invitation->email }}</li>
        <li class="listItem">Price: {{ $invitation->price }}</li>
        <li class="listItem">Request IP: {{ $invitation->request_ip }}</li>
        <li class="listItem">Browser: {{ $invitation->agent }}</li>
        <li class="listItem">Requested: {{ $invitation->created_at->longRelativeToNowDiffForHumans() }}</li>
    </ul>

    <div class="flex justify-between items-center pt-4">

        <form action="{{ $approveUrl }}" method="post">
            @csrf
            @method('PUT')

            <x-primary-button>
                {{ __('Approve') }}
            </x-primary-button>

        </form>

        <form action="{{ $rejectUrl }}" method="post">
            @csrf
            @method('DELETE')

            <x-danger-button>
                {{ __('Reject') }}
            </x-danger-button>

        </form>

    </div>
</x-guest-layout>

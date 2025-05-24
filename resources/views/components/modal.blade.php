<div id="{{ $id ?? 'modal' }}" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        
        <!-- Modal panel -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <!-- Header -->
            <div class="bg-gray-50 px-4 py-3 border-b">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900" id="modal-title">
                        {{ $title }}
                    </h3>
                    <button type="button" class="close-modal text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Close</span>
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            
            <!-- Content -->
            <div class="p-6">
                {{ $slot }}
            </div>
            
            <!-- Footer -->
            @if(isset($footer))
            <div class="bg-gray-50 px-4 py-3 border-t flex justify-end space-x-2">
                {{ $footer }}
            </div>
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get the modal element
    const modal = document.getElementById('{{ $id ?? 'modal' }}');
    
    // Get all buttons that should open this modal
    const openButtons = document.querySelectorAll('[data-modal="{{ $id ?? 'modal' }}"]');
    
    // Get all close buttons within this modal
    const closeButtons = modal.querySelectorAll('.close-modal');
    
    // Function to open the modal
    function openModal() {
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }
    
    // Function to close the modal
    function closeModal() {
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
    
    // Add click event listeners to open buttons
    openButtons.forEach(button => {
        button.addEventListener('click', openModal);
    });
    
    // Add click event listeners to close buttons
    closeButtons.forEach(button => {
        button.addEventListener('click', closeModal);
    });
    
    // Close the modal when clicking outside
    modal.addEventListener('click', function(event) {
        if (event.target === modal) {
            closeModal();
        }
    });
    
    // Close the modal when pressing Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
            closeModal();
        }
    });
});
</script>

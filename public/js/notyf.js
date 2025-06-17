const notyf = new Notyf({
  duration: 3000,
  position: { x: 'center', y: 'top' },
  ripple: false,
  dismissible: true,
  dismissAction: {
    icon: {
      className: 'material-icons text-white',
      tagName: 'i',
      text: 'close'
    },
    action: (notyf) => notyf.close()
  },
  types: [{
    type: 'error',
    background: '#91011a',
    className: 'rounded-lg bg-[#91011a] text-white text-[11px] sm:text-sm md:text-base px-2 sm:px-4 py-1.5 sm:py-2 shadow-md font-sans font-semibold max-w-[95vw] w-fit min-w-[120px] min-h-[36px] sm:min-h-[44px]',
    icon: {
      className: 'material-icons',
      tagName: 'i',
      text: 'error'
    }
  },
  {
                type: 'sucess',
                background: '#368540',
                 className: 'rounded-lg bg-[#368540] text-white text-[11px] sm:text-sm md:text-base px-2 sm:px-4 py-1.5 sm:py-2 shadow-md font-sans font-semibold max-w-[95vw] w-fit min-w-[120px] min-h-[36px] sm:min-h-[44px] ',
                icon: {
                    className: 'material-icons',
                    tagName: 'i',
                    text: 'w'
                }
                },
                {
                type: 'success',
                background: '#368540',
                duration: 2000,
                dismissible: true
                }
    ]
});

function showError(message) {
  notyf.open({
    type: 'error',
    message: message
  });
}
function showSuccess(message) {
  notyf.open({
    type: 'success',
    message: message , 
    
  });
}
function showErrorRegister(message, position = { x: 'center', y: 'top' }) {
     notyf.open({
    type: 'error',
    message: message , 
    position: position
  });
}    
  
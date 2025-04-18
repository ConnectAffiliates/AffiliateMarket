import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

export const toastSuccess = (message: string) => {
  toast.success(message, {
    autoClose: 3000,
    position: toast.POSITION.TOP_RIGHT,
  });
};

export const toastError = (message: string) => {
  toast.error(message, {
    autoClose: 3000,
    position: toast.POSITION.TOP_RIGHT,
  });
};

export const toastInfo = (message: string) => {
  toast.info(message, {
    autoClose: 3000,
    position: toast.POSITION.TOP_RIGHT,
  });
};

export const toastWarning = (message: string) => {
  toast.warning(message, {
    autoClose: 3000,
    position: toast.POSITION.TOP_RIGHT,
  });
}; 
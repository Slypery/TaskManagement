import jQuery from 'jquery';
window.$ = window.jQuery = jQuery;
import './bootstrap';
import './modal_handler';

import Quill from 'quill';
window.Quill = Quill;
import 'quill/dist/quill.snow.css';

import 'select2/dist/css/select2.min.css';
import select2 from 'select2';
select2();

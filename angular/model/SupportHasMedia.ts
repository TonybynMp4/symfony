import {Support} from './Support';
import {MediaObject} from './MediaObject';

export interface SupportHasMedia {
	id: number;
	support?: Support;
	media?: MediaObject;
}
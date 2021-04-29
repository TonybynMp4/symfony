import {Support} from './Support';
import {MediaObject} from './MediaObject';

export interface SupportHasMediaObject {
	id: number;
	support?: Support;
	mediaObject?: MediaObject;
}
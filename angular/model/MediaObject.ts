import {SupportHasMediaObject} from './SupportHasMediaObject';

export interface MediaObject {
	id: number;
	filePath?: string;
	description?: string;
	supports?: Array<SupportHasMediaObject>;
}
import {SupportHasMedia} from './SupportHasMedia';

export interface MediaObject {
	id: number;
	filePath?: string;
	description?: string;
	supports?: Array<SupportHasMedia>;
}
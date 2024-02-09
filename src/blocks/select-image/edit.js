/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';

import {
	PanelBody,
	PanelRow,
	SelectControl,
	__experimentalBoxControl as BoxControl,
} from '@wordpress/components';

import { useDisabled } from '@wordpress/compose';
import { useSelect } from '@wordpress/data';
import { forEach } from 'lodash';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @param  root0 - Object destructuring
 * @param  root0.attributes - The attributes of the block
 * @param  root0.setAttributes - Function to set the attributes value
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 */
export default function Edit( { attributes, setAttributes } ) {
	const { attachmentId, colorPalette, paddingSize, marginSize } = attributes;

	const attachments = useSelect( ( select ) => {
		return select( 'core' ).getEntityRecords( 'postType', 'attachment', {
			per_page: 20,
			post_status: 'publish',
			media_type: 'image',
		} );
	} );

	const attachmentIds = [
		{
			value: 0,
			label: __( '-- Select --', 'products-slider-block' ),
		},
	];

	if ( attachments ) {
		forEach( attachments, ( attachment ) => {
			attachmentIds.push( {
				value: attachment.id,
				label: attachment.title.rendered,
			} );
		} );
	}

	const colorPaletteOptions = [
		{
			value: 'full',
			label: __( 'Full', 'kenyan-beads' ),
		},
		{
			value: 'simplified',
			label: __( 'Simplified', 'kenyan-beads' ),
		},
		{
			value: 'basic',
			label: __( 'Basic', 'kenyan-beads' ),
		},
	];

	const patternData = [
		[
			'<div class="bead bead-empty"><span></span></div>',
			'<div class="bead bead-vertical"><span style="background-color: #000000"></span></div>',
			'<div class="bead bead-empty"><span></span></div>',
		],
		[
			'<div class="bead bead-horizontal"><span style="background-color: #000000"></span></div>',
			'<div class="bead bead-empty"><span></span></div>',
			'<div class="bead bead-horizontal"><span style="background-color: #000000"></span></div>',
		],
		[
			'<div class="bead bead-empty"><span></span></div>',
			'<div class="bead bead-vertical"><span style="background-color: #000000"></span></div>',
			'<div class="bead bead-empty"><span></span></div>',
		],
	];

	// requires WordPress 6.1
	const disabledRef = useDisabled();

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Image', 'kenyan-beads' ) }>
					<PanelRow>
						<SelectControl
							label={ __( 'Attachment', 'kenyan-beads' ) }
							value={ attachmentId }
							options={ attachmentIds }
							onChange={ ( value ) =>
								setAttributes( {
									attachmentId: parseInt( value ),
								} )
							}
						/>
					</PanelRow>
					<PanelRow>
						<SelectControl
							label={ __( 'Color Palette', 'kenyan-beads' ) }
							value={ colorPalette }
							options={ colorPaletteOptions }
							onChange={ ( value ) =>
								setAttributes( { colorPalette: value } )
							}
						/>
					</PanelRow>
				</PanelBody>
				<PanelBody
					title={ __( 'Dimensions', 'kenyan-beads' ) }
					initialOpen={ false }
				>
					<BoxControl
						label={ __( 'Padding', 'kenyan-beads' ) }
						values={ paddingSize }
						allowReset={ false }
						onChange={ ( value ) =>
							setAttributes( {
								paddingSize: value,
							} )
						}
					/>
					<BoxControl
						label={ __( 'Margin', 'kenyan-beads' ) }
						values={ marginSize }
						allowReset={ false }
						onChange={ ( value ) =>
							setAttributes( {
								marginSize: value,
							} )
						}
					/>
				</PanelBody>
			</InspectorControls>
			<div { ...useBlockProps() }>{ beadsPattern() }</div>
		</>
	);

	function beadsPattern() {
		const wrapperClassName = 'bead-container';
		const scrollWrapperClassName = 'bead-scroll-container';

		const wrapperStyles = {};
		if ( paddingSize ) {
			wrapperStyles.paddingTop = paddingSize.top;
			wrapperStyles.paddingBottom = paddingSize.bottom;
			wrapperStyles.paddingLeft = paddingSize.left;
			wrapperStyles.paddingRight = paddingSize.right;
		}
		if ( marginSize ) {
			wrapperStyles.marginTop = marginSize.top;
			wrapperStyles.marginBottom = marginSize.bottom;
			wrapperStyles.marginLeft = marginSize.left;
			wrapperStyles.marginRight = marginSize.right;
		}

		return (
			<div className={ scrollWrapperClassName }>
				<div
					className={ wrapperClassName }
					style={ wrapperStyles }
					ref={ disabledRef }
				>
					{ patternData &&
						patternData.map( ( row, i ) => {
							return beadsLine( row, i );
						} ) }
				</div>
			</div>
		);
	}

	function beadsLine( patternDataRow, i ) {
		const lineClassName =
			i % 2 === 0 ? 'bead-line bead-row-odd' : 'bead-line bead-row-even';

		return (
			<div className={ lineClassName }>
				{ patternDataRow &&
					patternDataRow.map( ( bead, j ) => {
						return beadSingle( i, j );
					} ) }
			</div>
		);
	}

	function beadSingle( i, j ) {
		return (
			<div
				dangerouslySetInnerHTML={ {
					__html: patternData[ i ][ j ],
				} }
			></div>
		);
	}
}

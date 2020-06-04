package sidescroller.scene;

import java.util.ArrayList;
import java.util.List;
import java.util.function.BiFunction;

import javafx.scene.canvas.Canvas;
import javafx.scene.layout.Background;
import javafx.scene.layout.HBox;
import javafx.util.Pair;
import sidescroller.entity.GenericEntity;
import sidescroller.entity.property.Entity;
import sidescroller.entity.property.HitBox;
import sidescroller.entity.property.Sprite;
import sidescroller.entity.sprite.BackgroundSprite;
import sidescroller.entity.sprite.LandSprite;
import sidescroller.entity.sprite.PlatformSprite;
import sidescroller.entity.sprite.SpriteFactory;
import sidescroller.entity.sprite.TreeSprite;
import sidescroller.entity.sprite.tile.BackgroundTile;
import sidescroller.entity.sprite.tile.Tile;
import utility.Tuple;

public class MapBuilder implements MapBuilderInterface{
	private Tuple rowColCount;
	private Tuple dimension;
	private double scale;
	private Canvas canvas;
	private Entity background;
	private List<Entity> landMass, other;
	
	protected MapBuilder() {
		landMass = new ArrayList<>();
		other=new ArrayList<>();
	}
	
	public static MapBuilder createBuilder() {
		return new MapBuilder();
	}

	@Override
	public MapBuilder setCanvas(Canvas canvas) {
		this.canvas = canvas;
		return this;
	}

	@Override
	public MapBuilder setGrid(Tuple rowColCount, Tuple dimension) {
		this.rowColCount = rowColCount;
		this.dimension = dimension;
		return this;
	}

	@Override
	public MapBuilder setGridScale(double scale) {
		this.scale = scale;
		return this;
	}

	@Override
	public MapBuilder buildBackground(BiFunction<Integer, Integer, Tile> callback) {
		BackgroundSprite bSprite = SpriteFactory.get("Background");
		Sprite sprite = bSprite.init(scale, dimension, Tuple.pair(0, 0));
		bSprite.createSnapshot(canvas, rowColCount, callback);
		HitBox HBox = HitBox.build(0, 0, scale * dimension.x() * rowColCount.y(), scale * dimension.y() * rowColCount.x());
		background = new GenericEntity(sprite, HBox);
		return this;
	}

	@Override
	public MapBuilder buildLandMass(int rowPos, int colPos, int rowConut, int colCount) {
		LandSprite lSprite = SpriteFactory.get("Land");
		Sprite ls = lSprite.init(scale, dimension, Tuple.pair( colPos, rowPos));
		lSprite.createSnapshot(canvas, rowConut, colCount);
		HitBox hBox = HitBox.build(colPos * dimension.x() * scale, rowPos * dimension.y() * scale, scale * dimension.x() * colCount, scale * dimension.y() * rowConut);
		GenericEntity gmEntity = new GenericEntity(ls, hBox);
		landMass.add(gmEntity);
		return this;
	}

	@Override
	public MapBuilder buildTree(int rowPos, int colPos, Tile tile) {
		TreeSprite tSprite = SpriteFactory.get("Tree");
		Sprite ts = tSprite.init(scale, dimension, Tuple.pair( colPos, rowPos));
		tSprite.createSnapshot(canvas, tile);
		GenericEntity gtEntity = new GenericEntity(ts, null);
		other.add(gtEntity);
		return this;
	}

	@Override
	public MapBuilder buildPlatform(int rowPos, int colPos, int length, Tile tile) {
		PlatformSprite pSprite = SpriteFactory.get("Platform");
		Sprite sp = pSprite.init(scale, dimension, Tuple.pair( colPos, rowPos));
		pSprite.createSnapshot(canvas, tile, length);
		HitBox platformBox = HitBox.build((colPos + .5) * dimension.x() * scale, rowPos * dimension.y() * scale, scale * dimension.x() * (length - 1), scale * dimension.y() / 2);
		GenericEntity pEntity = new GenericEntity(sp, platformBox);
		other.add(pEntity);
		return this;
	}

	@Override
	public Entity getBackground() {
		return background;
	}

	@Override
	public List<Entity> getEntities(List<Entity> list) throws NullPointerException{
		list.addAll(landMass);
		list.addAll(other);
		return list;
	}
	
	

}
